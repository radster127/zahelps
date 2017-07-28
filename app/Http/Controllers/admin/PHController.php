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

class PHController extends Controller
{
    public function __construct() {
    // Links
    $this->list_url = 'admin/ph';

    // Model and Module name
    $this->module = "PH";
    $this->modelObj = new PH;

    $this->deleteMsg = $this->module . " has been deleted successfully!";
    $this->deleteErrorMsg = $this->module . " can not deleted!";

    // View
    $this->veiw_base = 'admin.ph';

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

    $data['ph_settings'] = $this->ph_settings;
    $data['web_settings'] = $this->web_settings;

    return view($this->veiw_base . '.index', $data);
  }

  public function show($id, Request $request) {
    $data['ph_settings'] = $this->ph_settings;
    $data['gh_settings'] = $this->gh_settings;
    $data['web_settings'] = $this->web_settings;
    $data['ph_item'] = PH::findOrFail($id);

    $data['pairs'] = Pair::findByPHId($id);

    return view($this->veiw_base . '.show', $data);
  }

  public function create() {
    $data['ph_settings'] = $this->ph_settings;
    return view($this->veiw_base . '.create', $data);
  }

  public function store(Request $request) {
    //dd($request->all());

    $validator = Validator::make($request->all(), [
                'amount' => 'required|integer',
                'user_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return redirect('admin/ph/create')
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
        $requestArr['lock_ph'] = Carbon::now()->addHours($this->ph_settings['lock_before_pairing']);
      else
        $requestArr['lock_ph'] = Carbon::now();


      $requestArr['status'] = 'pending';

      //dd($requestArr);
      $gh = PH::create($requestArr);

      session()->flash('success_message', 'PH Request has been added to ' . $user->username);
      return redirect('admin/ph/create');
    }
  }

  public function destroy(Request $request, $id) {
    $model = $this->modelObj;
    $modelObj = $model::find($id);
    $modelObjTemp = $modelObj;

    if ($modelObj) {
      try {
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

  public function freeze($id) {
    $ph_item = PH::find($id);
    if ($ph_item) {
      if ($ph_item->is_freeze == '1') {
        $ph_item->is_freeze = '0';
      } else {
        $ph_item->is_freeze = '1';
      }
      $ph_item->save();
      return ['status' => '1', 'message' => 'Changed Successfully', 'freeze_status' => $ph_item->is_freeze];
    } else {
      return ['status' => '0', 'message' => 'No PH Request found'];
    }
  }
}
