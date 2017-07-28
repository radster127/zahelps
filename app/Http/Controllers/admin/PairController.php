<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models [start]
use App\User;
use App\GH;
use App\PH;
use App\Pair;
use App\Custom;
use Carbon\Carbon;

class PairController extends Controller
{
    public function __construct() {
    // Links
    $this->list_url = 'admin/pair';

    // Model and Module name
    $this->module = "Pair";
    $this->modelObj = new Pair;

    $this->deleteMsg = $this->module . " has been deleted successfully!";
    $this->deleteErrorMsg = $this->module . " can not deleted!";

    // View
    $this->veiw_base = 'admin.pair';

    $this->gh_settings = Custom::getSettings('get_help');
    $this->ph_settings = Custom::getSettings('provide_help');
    $this->profit_settings = Custom::getSettings('profit');
    $this->web_settings = Custom::getSettings('web');
  }

  public function index(Request $request) {
    $list_params = Custom::getListParams($request);
    $list_params['record_per_page'] = '25';
    $rows = $this->modelObj->getAdminList($list_params);
    $data['rows'] = $rows;
    $data['list_params'] = $list_params;
    $data['searchColumns'] = $this->modelObj->getSearchColumns();
    $data['with_date'] = 1;

    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    return view($this->veiw_base . '.index', $data);
  }

  public function create() {
    $data = [];
    return view($this->veiw_base . '.create', $data);
  }

  public function store(Request $request) {

    $validator = Validator::make($request->all(), [
                'gh_user_id' => 'required|integer',
                'ph_user_id' => 'required|integer',
                'amount' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('admin/pair/create')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      if ($request->get('gh_user_id') == $request->get('ph_user_id')) {
        return redirect('admin/pair/create')
                        ->withErrors(['gh_user_id' => 'You can not select same user for GH and PH'])
                        ->withInput();
      }

      // create GH [start]
      $ghUser = User::find($request->get('gh_user_id'));
      $ghRequestArr['amount'] = $request->get('amount');
      $ghRequestArr['user_id'] = $request->get('gh_user_id');
      $ghRequestArr['transaction_code'] = Custom::getRandomString(10);
      $ghRequestArr['user_information'] = json_encode($ghUser->toArray());
      $ghRequestArr['pending_amount'] = $request->get('amount');

      $ghRequestArr['ip_address'] = $request->ip();

      $ghRequestArr['lock_gh'] = Carbon::now();
      $ghRequestArr['status'] = 'pending';

      //dd($ghRequestArr);
      $gh_item = GH::create($ghRequestArr);
      // create GH [end]
      // create PH [start]
      $phUser = User::find($request->get('ph_user_id'));
      $phRequestArr['amount'] = $request->get('amount');
      $phRequestArr['user_id'] = $request->get('ph_user_id');
      $phRequestArr['transaction_code'] = Custom::getRandomString(10);

      $phRequestArr['profit_per_day_percentage'] = $this->profit_settings['profit_per_day'];
      $phRequestArr['profit_total_days'] = $this->profit_settings['duration_for_profit'];
      $phRequestArr['profit_day_counter'] = $this->profit_settings['duration_for_profit'];

      $phRequestArr['user_information'] = json_encode($ghUser->toArray());
      $phRequestArr['pending_amount'] = $request->get('amount');

      $phRequestArr['ip_address'] = $request->ip();

      $phRequestArr['lock_gh'] = Carbon::now();
      $phRequestArr['status'] = 'pending';

      //dd($phRequestArr);
      $ph_item = PH::create($phRequestArr);
      // create PH [end]

      Pair::create([
          'gh_id' => $gh_item->id,
          'ph_id' => $ph_item->id,
          'expired_on' => Carbon::now()->addDays(2),
          'amount' => $request->get('amount'),
          'token' => Custom::getRandomString(16),
          'status' => 'approved',
          'payment_type' => 'bank',
          'admin_generated' => '1',
      ]);

      $gh_item->status = 'approved';
      $gh_item->pending_amount = 0;
      $gh_item->save();

      $ph_item->status = 'approved';
      $ph_item->pending_amount = 0;
      $ph_item->save();
    }

    session()->flash('success_message', 'Pair has been added succesfully.');
    return redirect($this->list_url);
  }

  public function destroy(Request $request, $id) {
    $model = $this->modelObj;
    $modelObj = $model::find($id);
    $modelObjTemp = $modelObj;



    if ($modelObj) {
      try {

        //dd($modelObj->toArray());
        // make PH correct.
        if ($modelObj->ph_id > 0) {
          $ph_item = PH::find($modelObj->ph_id);
          if ($ph_item) {

            $ph_item->pending_amount += $modelObj->amount;

            if ($ph_item->pending_amount > $ph_item->amount) {
              $ph_item->pending_amount = $ph_item->amount;
            }
            if (Pair::where('ph_id', '=', $ph_item->id)->count() <= 0) {
              $ph_item->status = 'pending';
            }
            $ph_item->save();
          }
        }

        // make GH correct
        if ($modelObj->gh_id > 0) {
          $gh_item = GH::find($modelObj->gh_id);
          if ($gh_item) {

            $gh_item->pending_amount += $modelObj->amount;

            if ($gh_item->pending_amount > $gh_item->amount) {
              $gh_item->pending_amount = $gh_item->amount;
            }
            if (Pair::where('gh_id', '=', $gh_item->id)->count() <= 0) {
              $gh_item->status = 'pending';
            }
            $gh_item->save();
          }
        }

        $modelObj->delete();
        session()->flash('success_message', $this->deleteMsg);
        return redirect($this->list_url);
      } catch (Exception $e) {
        session()->flash('error_message', $this->deleteErrorMsg);
        return redirect($this->list_url);
      }
    } else {
      session()->flash('error_message', "Record not exists");
      return redirect($this->list_url);
    }
  }
}
