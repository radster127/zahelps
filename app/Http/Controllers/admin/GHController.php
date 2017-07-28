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

class GHController extends Controller
{
    public function __construct() {
    // Links
    $this->list_url = 'admin/gh';

    // Model and Module name
    $this->module = "GH";
    $this->modelObj = new GH;

    $this->deleteMsg = $this->module . " has been deleted successfully!";
    $this->deleteErrorMsg = $this->module . " can not deleted!";

    // View
    $this->veiw_base = 'admin.gh';

    $this->gh_settings = Custom::getSettings('get_help');
    $this->ph_settings = Custom::getSettings('provide_help');
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

    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    return view($this->veiw_base . '.index', $data);
  }

  public function pending(Request $request) {
    $list_params = Custom::getListParams($request);
    $list_params['record_per_page'] = '25';
    $list_params['pending_gh_only'] = true;
    $rows = $this->modelObj->getAdminList($list_params);
    $data['rows'] = $rows;
    $data['list_params'] = $list_params;
    $data['searchColumns'] = $this->modelObj->getSearchColumns();
    $data['with_date'] = 1;

    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    return view($this->veiw_base . '.pending', $data);
  }

  public function show($id, Request $request) {
    $data['gh_settings'] = $this->gh_settings;
    $data['ph_settings'] = $this->ph_settings;
    $data['web_settings'] = $this->web_settings;
    $data['gh_item'] = GH::findOrFail($id);

    $data['pairs'] = Pair::findByGHId($id);



    return view($this->veiw_base . '.show', $data);
  }

  public function create() {
    $data['gh_settings'] = $this->gh_settings;
    return view($this->veiw_base . '.create', $data);
  }

  public function store(Request $request) {
    //dd($request->all());

    $validator = Validator::make($request->all(), [
                'amount' => 'required|integer',
                'user_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return redirect('admin/gh/create')
                      ->withErrors($validator)
                      ->withInput();
    } else {


      $requestArr = $request->all();

      $user = User::find($requestArr['user_id']);

      $requestArr['transaction_code'] = Custom::getRandomString(10);
      $requestArr['user_information'] = json_encode($user->toArray());
      $requestArr['pending_amount'] = $request->get('amount');

      $requestArr['ip_address'] = $request->ip();

      if ($this->gh_settings['lock_before_pairing'] > 0)
        $requestArr['lock_gh'] = Carbon::now()->addHours($this->gh_settings['lock_before_pairing']);
      else
        $requestArr['lock_gh'] = Carbon::now();


      $requestArr['status'] = 'pending';

      //dd($requestArr);
      $gh = GH::create($requestArr);

      session()->flash('success_message', 'GH Request has been added to ' . $user->username);
      return redirect('admin/gh/create');
    }
  }

  public function destroy(Request $request, $id) {
    $model = $this->modelObj;
    $modelObj = $model::find($id);
    $modelObjTemp = $modelObj;

    if ($modelObj) {
      try {

        if ($modelObj->user_id > 0) {
          $gh_user = User::find($modelObj->user_id);


          $gh_user->account_balance += $modelObj->pending_amount;
          $gh_user->save();
        }


        $modelObj->delete();
        session()->flash('success_message', $this->deleteMsg);
        return back();
      } catch (Exception $e) {
        session()->flash('error_message', $this->deleteErrorMsg);
        return back();
      }
    } else {
      session()->flash('error_message', "Record not exists");
      return back();
    }
  }

  public function freeze($id) {
    $gh_item = GH::find($id);
    if ($gh_item) {
      if ($gh_item->is_freeze == '1') {
        $gh_item->is_freeze = '0';
      } else {
        $gh_item->is_freeze = '1';
      }
      $gh_item->save();
      return ['status' => '1', 'message' => 'Changed Successfully', 'freeze_status' => $gh_item->is_freeze];
    } else {
      return ['status' => '0', 'message' => 'No GH Request found'];
    }
  }

  public function pendingPHList($gh_id, Request $request) {

    $list_params = Custom::getListParams($request);
    $list_params['record_per_page'] = '25';

    $data['list_params'] = $list_params;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;

    $gh_item = GH::where([
                ['id', '=', $gh_id],
                ['pending_amount', '>', 0]
            ])->first();

    if (!$gh_item) {
      abort('404');
    } else {
      $data['gh_item'] = $gh_item;
      // get list of pending PH
      $data['rows'] = PH::where([
                  ['pending_amount', '>', 0],
                  ['is_freeze', '=', '0'],
                 
              ])->paginate(25);
    }
    return view($this->veiw_base . '.pending-ph-list', $data);
  }

  public function makeManuallPair($gh_id, $ph_id) {

    $gh_item = GH::findOrFail($gh_id);
    $ph_item = PH::findOrFail($ph_id);

    if ($gh_item->pending_amount <= 0) {
      session()->flash('error_message', 'GH request has no pending amount');
      return back();
    }
    if ($ph_item->pending_amount <= 0) {
      session()->flash('error_message', 'PH request has no pending amount');
      return back();
    }

    if ($ph_item->pending_amount == $gh_item->pending_amount) {
      Custom::createPair($gh_item, $ph_item, $ph_item->pending_amount);
    } elseif ($ph_item->pending_amount > $gh_item->pending_amount) {
      Custom::createPair($gh_item, $ph_item, $gh_item->pending_amount);
    } elseif ($ph_item->pending_amount < $gh_item->pending_amount) {
      Custom::createPair($gh_item, $ph_item, $ph_item->pending_amount);
    }

    session()->flash('success_message', 'Paired Successfully');
    return redirect('admin/gh/pending');
  }
}
