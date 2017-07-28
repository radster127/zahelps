<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models [start]
use App\Custom;
use App\PH;
use App\GH;
use App\Pair;
use App\Setting;
use App\Message;
use \Carbon\Carbon;
use \App\PhProfitHistory;
use Mail;

class PHController extends Controller
{
    public function __construct() {
	    $this->ph_settings = Custom::getSettings('provide_help');
	    $this->gh_settings = Custom::getSettings('get_help');
	    $this->profit_settings = Custom::getSettings('profit');
	    $this->web_settings = Custom::getSettings('web');

	    $this->base_view = 'member.ph.';
	}

  public function provideHelp(Request $request) {
    $data['ph_settings'] = $this->ph_settings;
    $data['web_settings'] = $this->web_settings;
    //\Carbon\Carbon('last 30 days')

    $countQueryCluases = [
        ['user_id', '=', Auth::user()->id],
        ['created_at', '>=', Carbon::now()->subMonth()],
    ];

    $data['last_30_days_ph_req_count'] = PH::where($countQueryCluases)->count();
    //dd($data);
    return view($this->base_view . 'provide-help', $data);
  }

  public function storeProvideHelp(Request $request) {

    $validator = Validator::make($request->all(), [
                'amount' => 'required|integer',
                'captcha' => 'required|captcha'
                    ], [
                'captcha' => 'The :attribute code is wrong.'
    ]);

    if ($validator->fails()) {
      return redirect('member/provide-help')
                      ->withErrors($validator)
                      ->withInput();
    } else {


      $countQueryCluases = [
          ['user_id', '=', Auth::user()->id],
          ['created_at', '>=', Carbon::now()->subMonth()],
      ];

      $last_30_days_ph_req_count = PH::where($countQueryCluases)->count();
      if ($last_30_days_ph_req_count >= $this->ph_settings['max_ph_per_month']) {
        session()->flash('error_message', "Sorry, You can not provide help more. You already provide help " . $this->ph_settings['max_ph_per_month'] . " times in last 30 days.");
        return redirect('member/provide-help')
                        ->withInput();
      }

      $requestArr = $request->all();

      $requestArr['user_id'] = Auth::user()->id;
      $requestArr['transaction_code'] = Custom::getRandomString(10);
      $requestArr['profit_per_day_percentage'] = $this->profit_settings['profit_per_day'];
      $requestArr['profit_total_days'] = $this->profit_settings['duration_for_profit'];
      $requestArr['profit_day_counter'] = 0;
      $requestArr['user_information'] = json_encode(Auth::user()->toArray());
      $requestArr['pending_amount'] = $request->get('amount');

      if ($this->ph_settings['admin_commission'] == '1') {
        $requestArr['admin_commission_percentage'] = $this->ph_settings['admin_commission_per'];
        $admin_commission = $request->get('amount') * $requestArr['admin_commission_percentage'] / 100;
        $requestArr['admin_commission'] = $admin_commission;
      }

      $requestArr['ph_capital'] = $request->get('amount') - 0; // amount - admin_commission
      $requestArr['ph_profit'] = 0;
      //$requestArr['profit_start_datetime'] = Carbon::now()->addDay(1);
      $requestArr['profit_start_datetime'] = Carbon::now();
      //$requestArr['now'] = Carbon::now()->toDateTimeString();

      if ($this->ph_settings['lock_before_pairing'] > 0)
        $requestArr['lock_ph'] = Carbon::now()->addHours($this->gh_settings['lock_before_pairing']);
      else
        $requestArr['lock_ph'] = Carbon::now();

      $requestArr['ip_address'] = $request->ip();
      $requestArr['status'] = 'pending';

      //dd($requestArr);



      $ph = PH::create($requestArr);

      //emailNotification
      Mail::send('Data', $data, function($message) use($data){
          $message->from('radster127@gmail.com', 'Learning Laravel');
        $message->to('radster127@gmail.com')->subject('Transaction Confirmation');
      });      






      session()->flash('success_message', 'Your provide help request has been added.');
     // return redirect("member/sendEmail");
      return redirect('member/provide-help');
    }
  }

  public function cancelPH(Request $request) {
    $returnArr = ['status' => 0];

    $ph = PH::find($request->get('ph_id'));
    if ($ph) {
      if ($ph->user_id != Auth::user()->id) {
        $returnArr['message'] = 'Specified PH is not owned by you';
      } else {
        // delete PH request
        $ph->delete();
        $returnArr = [
            'status' => 1,
            'message' => 'Your PH request has been deleted'
        ];
      }
    } else {
      $returnArr['message'] = 'PH not found';
    }
    return $returnArr;
  }

  public function detail($token) {

    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    $pair_item = Pair::where('token', '=', $token)->first();
    if (!$pair_item) {
      session()->flash('error_message', 'provide help request not found.');
      return redirect('member/dashboard');
    }

    if ($pair_item->PH->user_id != Auth::user()->id) {
      return abort('404');
    }

    $data['pair_item'] = $pair_item;
    $data['pair_messages'] = Message::where('pair_id', '=', $pair_item->id)->get();

    //dd($data);

    return view($this->base_view . 'detail', $data);
  }

  public function history(Request $request) {

    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    // My Pending PH Requests
    $data['ph_pending_list'] = PH::myPendingPH();

    // My Pending GH Requests
    $data['gh_pending_list'] = GH::myPendingGH();

    // my paired but not completed PH requests.
    $data['ph_paired_list'] = Pair::myPairedPH(Auth::user()->id, ['paired', 'approved', 'completed']);
    //dd($data);

    return view($this->base_view . 'history', $data);
  }

  public function confirmPayment(Request $request) {

    $pair_item = Pair::find($request->get('pair_id'));

    if (!$pair_item) {
      session()->flash('error_message', 'provide help request not found.');
      return redirect('member/dashboard');
    }

    $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";

    $validator = Validator::make($request->all(), [
                'proof_picture' => 'mimes:jpeg,bmp,png,gif,jpg',
                'transferred_amount' => 'required',
    ]);

    if ($validator->fails()) {
      return back()
                      ->withErrors($validator)
                      ->withInput();
    } else {


      if ($request->hasFile('proof_picture')) {
        $image = $request->file('proof_picture');
        $filename = time() . rand(0, 9999999) . '.' . $image->getClientOriginalExtension();

        $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . 'payment_proof' . DIRECTORY_SEPARATOR . $pair_item->id;

        $filename = $image->getClientOriginalName();
        $fullpath = $uploadPath . DIRECTORY_SEPARATOR . $filename;
        $filename = \App\Custom::getFilename($fullpath, $filename);


        Custom::removeProofPicture($pair_item);

        $image->move($uploadPath, $filename);

        $pair_item->proof_picture = $filename;
        $pair_item->payment_type = $request->get('payment_type');
        $pair_item->transferred_amount = $request->get('transferred_amount');

        $pair_item->auto_approved_on = Carbon::now()->addDays(2);
        $pair_item->save();

        $baseFilePath = public_path() . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR;
        $baseFileName = $filename;

        \App\Custom::createThumnails($baseFilePath, $baseFileName);
      }


      if ($request->get('message') != '') {
        Message::sendPairMessage([
            'pair_id' => $pair_item->id,
            'from_id' => Auth::user()->id,
            'to_id' => $pair_item->GH->user_id,
            'message' => $request->get('message'),
        ]);
      }

      session()->flash('success_message', $this->ph_settings['name'] . ' request has been confirmed.');
    }

    return redirect(route('ph-detail', ['token' => $pair_item->token]));
    //return redirect('member/dashboard');
  }

  public function myPhProfitHistory(Request $request) {
    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;


    $data['searchColumns'] = [
        'all' => 'All',
        'tb_ph.transaction_code' => 'Transaction Code',
        'ph_profit_history.profit_percentage' => 'Profit Percentage',
        'ph_profit_history.profit_amount' => 'Profit Amount',
    ];
    $data['with_date'] = 1;

    $list_params = Custom::getListParams($request);
    $data['list_params'] = $list_params;

    //$data['profits'] = PhProfitHistory::myPHProfitHistory(Auth::user()->id, $list_params);
    $data['ph_list'] = PH::myPHProfitHistory(Auth::user()->id, $list_params);

    return view($this->base_view . 'my-ph-profit-history', $data);
  }

  public function myDownlinePhProfitHistory(Request $request) {
    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;


    $data['searchColumns'] = [
        'all' => 'All',
        'tb_ph.transaction_code' => 'Transaction Code',
        'ph_profit_history.profit_percentage' => 'Profit Percentage',
        'ph_profit_history.profit_amount' => 'Profit Amount',
        'ph_profit_history.level_number' => 'Level',
    ];
    $data['with_date'] = 1;

    $list_params = Custom::getListParams($request);
    $data['list_params'] = $list_params;

    $data['profits'] = PhProfitHistory::myDownlinePHProfitHistory(Auth::user()->id, $list_params);

    return view($this->base_view . 'my-downline-ph-profit-history', $data);
  }

  public function directorPhProfitHistory(Request $request) {
    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;


    $data['searchColumns'] = [
        'all' => 'All',
        'tb_ph.transaction_code' => 'Transaction Code',
        'ph_profit_history.profit_percentage' => 'Profit Percentage',
        'ph_profit_history.profit_amount' => 'Profit Amount',
        'ph_profit_history.level_number' => 'Level',
    ];
    $data['with_date'] = 1;

    $list_params = Custom::getListParams($request);
    $data['list_params'] = $list_params;

    $data['profits'] = PhProfitHistory::directorPHProfitHistory(Auth::user()->id, $list_params);

    return view($this->base_view . 'director-ph-profit-history', $data);
  }

  /*public function emailNotification(Request $request){
    Mail::send('mails.confirmation', $data, function($message) use($data){
      $message->to($data['email']);
      $message->subject('Transaction Confirmation');
    });
    return redirect(route('login'))->('status', 'Confirmation emaul has been send. please check youir email.');
  }*/

}
