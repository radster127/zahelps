<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
// Models [start]
use App\User;
use App\PH;
use App\GH;
use App\Country;
use App\Custom;
use App\UserLoginLog;
use App\MemberLog;
use App\Manager;
use App\News;
use Mail;

class UserController extends Controller
{
    public function __construct() {

    $this->profile_link = 'member/profile';
    $this->add_member_link = 'member/add-member';

    $this->base_view = 'member.user.';
  }

    //
  public function myPage() {
    $data['news'] = News::orderBy('id', 'DESC')->limit(5)->get();
    $data['user'] = Auth::user();

    $data['direct_referrals'] = User::where('user_id', '=', $data['user']->id)->count();
    $data['total_downline'] = MemberLog::where('user_id', '=', $data['user']->id)->count();

    $data['approved_ph_amount'] = PH::where('user_id', '=', $data['user']->id)
            ->where('pending_amount', '=', 0)
            ->where('status', '=', 'approved')
            ->sum('amount');

    $data['approved_gh_amount'] = GH::where('user_id', '=', $data['user']->id)
            ->where('pending_amount', '=', 0)
            ->where('status', '=', 'approved')
            ->sum('amount');

    //dd($data);
    return view($this->base_view . 'my-page', $data);
  }

  /* profile */

  public function profile() {
    $data['user'] = User::find(Auth::user()->id);
    $data['countries'] = Country::pluck('country_name', 'id');
    return view($this->base_view . 'profile', $data);
  }

  public function updateProfile(Request $request) {

    $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|unique:users,phone,' . Auth::user()->id . ',id',
                'bank_name' => 'required',
                'bank_account_number' => 'required',
                'bank_account_name' => 'required',
    ]);


    if ($validator->fails()) {
      return redirect($this->profile_link)
                      ->withErrors($validator)
                      ->withInput();
    } else {
      $user = User::findOrFail(Auth::user()->id);
      $user->update($request->all());

      session()->flash('success_message', 'Profile has been updated');
      return redirect($this->profile_link);
    }
  }

  /* create member */

  public function createMember() {
    $data['countries'] = Country::pluck('country_name', 'id');
    return view($this->base_view . 'add-member', $data);
  }

  public function storeMember(Request $request) {
    $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required|min:6|max:50',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
                'bank_name' => 'required',
                'bank_account_number' => 'required',
                'bank_account_name' => 'required',
    ]);

    if ($validator->fails()) {
      return redirect($this->add_member_link)
                      ->withErrors($validator)
                      ->withInput();
    } else {
      $requestArr = $request->all();

      $requestArr['user_type'] = 'member';
      $requestArr['ip_address'] = $request->ip();
      $requestArr['password'] = bcrypt($requestArr['password']);

      $user = User::create($requestArr);

      $user->joining_datetime = $user->created_at;
      $user->save();


      // add member log
      MemberLog::addLog(1, $request->get('user_id'), $user->id);

      session()->flash('success_message', 'New member has been created successfully');
      return redirect($this->add_member_link);
    }
  }

  public function register() {

    if (Auth::check()) {
      return redirect('member/dashboard');
    }

    $data['countries'] = Country::pluck('country_name', 'id');
    return view($this->base_view . 'register', $data);
  }

  public function referralRegister($username) {
    if (Auth::check()) {
      return redirect('member/dashboard');
    }

    $user = User::where('username', '=', $username)->first();

    if (!$user) {
      return redirect('member/register');
    }

    $data['countries'] = Country::pluck('country_name', 'id');
    $data['sponsor'] = ['id' => $user->id, 'name' => $user->username];
    return view($this->base_view . 'register', $data);
  }

  public function storeRegister(Request $request) {

    $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required|min:6|max:50'
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)
                      ->withInput();
    } else {
      $requestArr = $request->all();


      $requestArr['user_type'] = 'member';
      $requestArr['ip_address'] = $request->ip();
      $requestArr['password'] = bcrypt($requestArr['password']);

      $user = User::create($requestArr);

      $user->joining_datetime = $user->created_at;
      $user->save();

// add member log
      MemberLog::addLog(1, $request->get('user_id'), $user->id);



      if (Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')], $request->has('remember'))) {
        $user = Auth::user();

// add user login
        $obj = new UserLoginLog;
        $obj->user_id = $user->id;
        $obj->ip = $request->ip() == "" ? '-' : $request->ip();
        $obj->save();

        $user->last_login_datetime = \Carbon\Carbon::now();
        $user->ip_address = $request->ip();
        $user->save();

        session()->flash('success_message', 'You have been registered successfully, Kindly fill up your all informations');
      }
      return redirect()->intended($this->profile_link);
    }
  }

  public function changePassword() {
    return view($this->base_view . 'change-password');
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
      return redirect('member/change-password')
                      ->withErrors($validator)
                      ->withInput();
    } else {

// check for old password

      if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
        return redirect('member/change-password')
                        ->withErrors(['old_password' => 'Old password do not matched!'])
                        ->withInput();
      }

      $formObj->password = bcrypt($request->get('new_password'));
      $formObj->save();
      session()->flash('success_message', 'Password has been changed.');
      Auth::logout();
      return redirect('member/login');
    }
  }

  public function avatar() {
    $data['user'] = Auth::user();
    return view($this->base_view . 'avatar');
  }

  public function updateAvatar(Request $request) {

    $backPage = 'member/change-avatar';

    if ($request->has('back_page') && $request->get('back_page') != '') {
      $backPage = $request->get('back_page');
    }

    $validator = Validator::make($request->all(), [
                'avatar' => 'mimes:jpeg,bmp,png,gif,jpg',
    ]);

    if ($validator->fails()) {
      return redirect($backPage)
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $obj = Auth::user();

      if ($request->hasFile('avatar')) {
        $image = $request->file('avatar');
        $filename = time() . rand(0, 9999999) . '.' . $image->getClientOriginalExtension();

        $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . 'members' . DIRECTORY_SEPARATOR . $obj->id;

        $filename = $image->getClientOriginalName();
        $fullpath = $uploadPath . DIRECTORY_SEPARATOR . $filename;
        $filename = \App\Custom::getFilename($fullpath, $filename);


        Custom::removeUserAvatar($obj);

        $image->move($uploadPath, $filename);

        $obj->avatar = $filename;
        $obj->save();

        $baseFilePath = public_path() . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR;
        $baseFileName = $filename;

        \App\Custom::createThumnails($baseFilePath, $baseFileName);
      }
    }
    session()->flash('success_message', 'Avatar Image has been changed successfully.');
    return redirect($backPage);
  }

  public function getUsers(Request $request) {
    $searchText = $request->get('q');
    $whereClause = [
        ['username', 'like', '%' . $searchText . '%'],
        ['status', '=', 'active'],
        ['suspended', '=', '0'],
    ];

    if ($request->has('current_user') && $request->get('current_user') == 'no') {
      $whereClause[] = ['id', '!=', Auth::user()->id];
    }
    $result = User::where($whereClause)->select('username as name', 'id')->limit(10)->get();
    return $result;
  }

  public function myDownLine(Request $request, $id = 0) {
    $user_id = Auth::user()->id;
    if ($id > 0) {
      $user_id = $id;
    }

    $data['user'] = User::findOrFail($user_id);
    $data['users'] = User::where('user_id', '=', $user_id)->get();
    return view($this->base_view . 'my-downline', $data);
  }

  public function myLevels($level = 0) {
    $data['levels'] = MemberLog::where('user_id', '=', Auth::user()->id)->select([DB::raw('count(*) as total'), 'level_number'])->groupBy('level_number')->get();
    $data['colors'] = ['bg-purple', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-theme-dark', 'bg-primary', 'bg-info', 'bg-warning', 'bg-success'];
    return view($this->base_view . 'my-levels', $data);
  }

  public function levelMembers($level) {

    if (is_numeric($level) && ($level > 0 && $level <= 10)) {
      $data['level_number'] = $level;
      $data['users'] = User::where('member_log.user_id', '=', Auth::user()->id)
              ->where('member_log.level_number', '=', $level)
              ->select('users.*')
              ->leftJoin('member_log', 'member_log.member_id', '=', 'users.id')
              ->get();

      if (count($data['users']) <= 0) {
        session()->flash('error_message', "You don't have any member in level " . $level);
        return redirect('member/my-levels');
      }

      return view($this->base_view . 'level-members', $data);
    } else {
      session()->flash('error_message', 'Level number must be numeric and in between 1 to 10');
      return redirect('member/my-levels');
    }
  }

  public function directors() {

    $data['manager_list'] = Manager::all();
    if (count($data['manager_list']) > 0) {
      foreach ($data['manager_list'] as $manager) {

        $data['directors'][$manager->id] = User::where('manager_id', '=', $manager->id)
                ->where('suspended', '=', '0')
                ->orderBy('id', 'ASC')
                ->get();
      }
    }

    //dd($data);

    return view($this->base_view . 'director', $data);
  }

  //sending email notification
  public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }
}
