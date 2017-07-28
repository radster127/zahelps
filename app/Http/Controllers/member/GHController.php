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
use App\AccountLog;
use App\GH;
use App\PH;
use App\Pair;
use App\Message;
use App\Setting;
use \Carbon\Carbon;

class GHController extends Controller
{

    public function __construct() {
	    $this->ph_settings = Custom::getSettings('provide_help');
	    $this->gh_settings = Custom::getSettings('get_help');
	    $this->web_settings = Custom::getSettings('web');

	    $this->base_view = 'member.gh.';
	}

	public function getHelp(Request $request) {
	    $data['gh_settings'] = $this->gh_settings;
	    $data['web_settings'] = $this->web_settings;

	    $countQueryCluases = [
	        ['user_id', '=', Auth::user()->id],
	        ['created_at', '>=', Carbon::now()->subMonth()],
	    ];

	    $data['last_30_days_gh_req_count'] = GH::where($countQueryCluases)->count();
	    return view($this->base_view . 'get-help', $data);
  	}

  	public function storeGetHelp(Request $request) {

	    $validator = Validator::make($request->all(), [
	                'amount' => 'required|integer',
	                'captcha' => 'required|captcha'
	                    ], [
	                'captcha' => 'The :attribute code is wrong.'
	    ]);

	    if ($validator->fails()) {
	      return redirect('member/get-help')
	                      ->withErrors($validator)
	                      ->withInput();
	    } else {

	      // check for enough account balance
	      if ($request->get('amount') > Auth::user()->account_balance) {
	        session()->flash('error_message', "You don't have enough account balace to request a get help");
	        return redirect('member/get-help')
	                        ->withInput();
	      }

	      $countQueryCluases = [
	          ['user_id', '=', Auth::user()->id],
	          ['created_at', '>=', Carbon::now()->subMonth()],
	      ];

	      $last_30_days_gh_req_count = GH::where($countQueryCluases)->count();
	      if ($last_30_days_gh_req_count >= $this->gh_settings['max_gh_per_month']) {
	        session()->flash('error_message', "Sorry, You can not get help more. You already provide help " . $this->gh_settings['max_gh_per_month'] . " times in last 30 days.");
	        return redirect('member/get-help')
	                        ->withInput();
	      }



	      $requestArr = $request->all();

	      $requestArr['user_id'] = Auth::user()->id;
	      $requestArr['transaction_code'] = Custom::getRandomString(10);
	      $requestArr['user_information'] = json_encode(Auth::user()->toArray());
	      $requestArr['pending_amount'] = $request->get('amount');

	      $requestArr['ip_address'] = $request->ip();

	      if ($this->gh_settings['lock_before_pairing'] > 0)
	        $requestArr['lock_gh'] = Carbon::now()->addHours($this->gh_settings['lock_before_pairing']);
	      else
	        $requestArr['lock_gh'] = Carbon::now();


	      $requestArr['status'] = 'pending';

	      //dd($requestArr);
	      $gh = GH::create($requestArr);

	      // Deduct User Account Balance
	      $user = Auth::user();
	      $user->account_balance = $user->account_balance - $request->get('amount');
	      $user->save();

	      // add account log
	      AccountLog::addLog('credit', 'GH Request added', $request->get('amount'));


	      session()->flash('success_message', 'Your Get help request has been added.');
	      return redirect('member/get-help');
	    }
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
	    $data['gh_paired_list'] = Pair::myPairedGH(Auth::user()->id, ['paired', 'approved', 'completed', 'rejected']);
	    //dd($data);

	    return view($this->base_view . 'history', $data);
	}

	public function detail($token) {

	    $data['ph_settings'] = $this->ph_settings;
	    $data['gh_settings'] = $this->gh_settings;
	    $data['web_settings'] = $this->web_settings;

	    $pair_item = Pair::where('token', '=', $token)->first();
	    if (!$pair_item) {
	      session()->flash('error_message', 'Get help request not found.');
	      return redirect('member/dashboard');
	    }

	    if ($pair_item->GH->user_id != Auth::user()->id) {
	      return abort('404');
	    }

	    $data['pair_item'] = $pair_item;
	    $data['pair_messages'] = Message::where('pair_id', '=', $pair_item->id)->get();

	    return view($this->base_view . 'detail', $data);
	}

	public function approvePair(Request $request) {

	    $pair_item = Pair::find($request->get('pair_id'));

	    if ($pair_item) {
	      if ($pair_item->GH->user_id != Auth::user()->id) {
	        return ['status' => 0, 'message' => "You can not approve other member requests."];
	      } else {

	        // approve Pair
	        Custom::approvePair($pair_item);

	        return ['status' => 1, 'message' => "Your paired has been approved successfully"];
	      }
	    } else {
	      return ['status' => 0, 'message' => 'Pair not found'];
	    }
	}

	public function rejectPair(Request $request) {

	    $pair_item = Pair::find($request->get('pair_id'));

	    if ($pair_item) {
	      if ($pair_item->GH->user_id != Auth::user()->id) {
	        return ['status' => 0, 'message' => "You can not approve other member requests."];
	      } else {

	        // remove Pair
	        Custom::removePair($pair_item);

	        //$pair_item->save();
	        return ['status' => 1, 'message' => "Your paired has been rejected successfully"];
	      }
	    } else {
	      return ['status' => 0, 'message' => 'Pair not found'];
	    }
	}

}
