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
use App\Manager;
use App\Country;
use App\Custom;

class UserController extends Controller
{
    //
  public function __construct() {
    // Links
    $this->list_url = 'admin/users';
    $this->add_url = 'admin/users/create';
    $this->edit_url = 'admin/users/{id}/edit';

    // Model and Module name
    $this->module = "User";
    $this->moduleLocation = "User";
    $this->modelObj = new User;

    // Module Message
    $this->addMsg = $this->module . " has been added successfully!";
    $this->updateMsg = $this->module . " has been updated successfully!";
    $this->deleteMsg = $this->module . " has been deleted successfully!";
    $this->deleteErrorMsg = $this->module . " can not deleted!";

    // View
    $this->veiw_base = 'admin.users';
  }

  public function index(Request $request) {
    $list_params = Custom::getListParams($request);
    $list_params['record_per_page'] = '25';
    $rows = $this->modelObj->getAdminList($list_params);
    $data['rows'] = $rows;
    $data['list_params'] = $list_params;
    $data['searchColumns'] = $this->modelObj->getSearchColumns();
    $data['with_date'] = 1;
    return view($this->veiw_base . '.index', $data);
  }

  public function suspendedUsers(Request $request) {
    $list_params = Custom::getListParams($request);
    $list_params['suspended'] = '1';
    $list_params['record_per_page'] = '25';
    $rows = $this->modelObj->getAdminList($list_params);
    $data['rows'] = $rows;
    $data['list_params'] = $list_params;
    $data['searchColumns'] = $this->modelObj->getSearchColumns();
    $data['with_date'] = 1;
    return view($this->veiw_base . '.suspended-users', $data);
  }

  public function edit($id) {
    $model = $this->modelObj;
    $formObj = $model::findOrFail($id);
    $data['formObj'] = $formObj;
    $data['countries'] = Country::lists('country_name', 'id');
    return view($this->veiw_base . '.edit', $data);
  }

  public function update($id, Request $request) {
    //dd($request->all());
    $model = $this->modelObj;
    $formObj = $model::findOrFail($id);

    $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $formObj->id . ',id',
                'phone' => 'required',
                'bank_name' => 'required',
                'bank_account_number' => 'required',
                'bank_account_name' => 'required',
    ]);

    if ($validator->fails()) {

      $edit_url = $this->edit_url;
      $edit_url = str_replace('{id}', $id, $edit_url);

      return redirect($edit_url)
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $formObj->update($request->all());

      session()->flash('success_message', $this->updateMsg);
      return redirect($this->list_url);
    }
  }

  public function profile() {
    $data['formObj'] = Auth::user();
    $data['countries'] = Country::lists('country_name', 'id');
    return view($this->veiw_base . '.profile', $data);
  }

  public function updateProfile(Request $request) {
    $formObj = Auth::user();

    $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $formObj->id . ',id',
                'phone' => 'required',
                'bank_name' => 'required',
                'bank_account_number' => 'required|integer',
                'bank_account_name' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect('admin/profile')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $formObj->update($request->all());

      session()->flash('success_message', 'Profile has been updated');
      return redirect('admin/profile');
    }
  }

  public function suspend($id) {
    $user = User::findOrFail($id);
    $user->suspended = '1';
    $user->save();
    session()->flash('error_message', $user->username . ' has been suspended!');
    return back();
  }

  public function unsuspend($id) {
    $user = User::findOrFail($id);
    $user->suspended = '0';
    $user->save();
    session()->flash('success_message', $user->username . ' has been unsuspended!');
    return back();
  }

  public function changeUserPassword(Request $request) {
    $user = User::find($request->get('id'));
    if ($user) {
      $user->password = bcrypt($request->get('new_password'));
      $user->save();
      return array('status' => 1, 'message' => 'Password has been changed');
    } else {
      return array('status' => 0, 'message' => 'User not found');
    }
  }

  public function changePassword() {
    return view($this->veiw_base . '.change-password');
  }

  public function updatePassword(Request $request) {
    //dd($request->all());
    $model = new User;
    $id = Auth::user()->id;
    $formObj = $model::findOrFail($id);

    $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:6|max:50',
                'new_password' => 'required|min:6|max:50',
                'confirm_password' => 'required|min:6|max:50|same:new_password',
    ]);


    if ($validator->fails()) {
      return redirect('admin/change-password')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      // check for old password

      if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
        return redirect('admin/change-password')
                        ->withErrors(['old_password' => 'Old password do not matched!'])
                        ->withInput();
      }

      $formObj->password = bcrypt($request->get('new_password'));
      $formObj->save();
      session()->flash('success_message', 'Password has been changed.');
      Auth::logout();
      return redirect('admin/login');
    }
  }

  public function directors(Request $request) {

    $manager_id = $request->get('manager_id');
    $data['manager'] = Manager::findOrFail($manager_id);
    
    $list_params = Custom::getListParams($request);
    $list_params['record_per_page'] = 25;
    $list_params['manager_id'] = $manager_id;
    $rows = $this->modelObj->getAdminList($list_params);
    $data['rows'] = $rows;
    $data['list_params'] = $list_params;
    $data['searchColumns'] = $this->modelObj->getSearchColumns();
    $data['with_date'] = 1;
    return view($this->veiw_base . '.directors', $data);
  }

  public function removeDirector($user_id, $manager_id) {
    $user = User::findOrFail($user_id);
    $user->manager_id = NULL;
    $user->save();
    $manager = Manager::findOrFail($manager_id);
    session()->flash('success_message', $user->username . ' has been removed from ' . $manager->name);
    return back();
  }

  public function upgradeMembers() {

    // find pending directors
    $directorObj = Manager::find(1);
    $data['directors'] = User::pendingDirectors($directorObj->minimum_down_line);
    
    $srDirectorObj = Manager::find(2);
    $data['sr_directors'] = User::pendingSrDirectors($srDirectorObj->minimum_down_line);
    
    $principalDirectorObj = Manager::find(3);
    $data['principal_directors'] = User::pendingPrincipalDirectors($principalDirectorObj->minimum_down_line);
    
    $chiefDirectorObj = Manager::find(4);
    $data['chief_directors'] = User::pendingChiefDirectors($chiefDirectorObj->minimum_down_line);
    //dd($data);

    return view($this->veiw_base . '.upgrade-members', $data);
  }

  public function upgradeToDirector($user_id, $manager_id) {
    $user = User::findOrFail($user_id);
    $manager = Manager::findOrFail($manager_id);

    $user->manager_id = $manager_id;
    $user->save();

    session()->flash('success_message', $user->username . ' has been upgraded to ' . $manager->name);
    return redirect('admin/users/upgrade-members');
  }
}
