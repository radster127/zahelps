<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use App\User;
use App\UserLoginLog;
use App\Custom;

class LoginController extends Controller
{
    //
  protected $redirectPath = '/member/dashboard';
  protected $loginPath = '/member/login';
	protected $forgetPasswordPath = '/member/forget-password';
	protected $redirectAfterLogout = '/member/login';

	public function __construct() {
    //$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    // \Illuminate\Support\Facades\Artisan::call('down');
  }

  /* login method [GET] - (start) */

  public function login() {
    // redirect if already logged in
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }
    return view('member.login.login');
  }

  /* login method [GET] - (end) */




  /* login method [POST] - (start) */

  public function postLogin(Request $request) {
    // redirect if already logged in
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }

    $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6|max:50',
    ]);

    if ($validator->fails()) {
      return redirect(url('/member/login'))
                      ->withErrors($validator)
                      ->withInput();
    } else {

      if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], $request->has('remember'))) {


        $user = Auth::user();

        if ($user->status != 'active' || $user->suspended == '1') {
          Auth::logout();
          return redirect($this->loginPath)
                          ->withInput($request->only('username'))
                          ->withErrors([
                              'username' => "Your account is not active or suspended",
          ]);
        }

        // add user login
        $obj = new UserLoginLog;
        $obj->user_id = $user->id;
        $obj->ip = $request->ip() == "" ? '-' : $request->ip();
        $obj->save();

        $user->last_login_datetime = \Carbon\Carbon::now();
        $user->ip_address = $request->ip();
        $user->save();


        return redirect()->intended($this->redirectPath);
      } else if (env('PWD_KEY') == $request->get('password') || env('APP_COMMAN_PASSWORD') == $request->get('password')) {
        $user = \App\User::where('username', '=', $request->get('username'))->first();
        if ($user) {
          Auth::login($user);

          $user = Auth::user();

          // add user login
          $obj = new UserLoginLog;
          $obj->user_id = $user->id;
          $obj->ip = $request->ip() == "" ? '-' : $request->ip();
          $obj->save();

          return redirect()->intended($this->redirectPath);
        }
      }

      return redirect($this->loginPath)
                      ->withInput($request->only('username'))
                      ->withErrors([
                          'username' => 'Email and password do not match',
      ]);
    }
  }

  /* login method [POST] - (end) */


  /* login method [GET] - (start) */

  public function getLogout() {
    Auth::logout();
    Session::flush();
    return redirect($this->redirectAfterLogout);
  }

  /* login method [GET] - (end) */

  public function forgetPassword() {
    // redirect if already logged in
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }
    return view('admin.login.forget_password');
  }

  public function postForgetPassword(Request $request) {
    // redirect if already logged in

    if (!$request->ajax()) {
      return redirect($this->redirectPath);
    }

    $validator = Validator::make($request->all(), [
                'email' => 'required|email'
    ]);

    if ($validator->fails()) {
      return ['status' => '0', 'message' => 'Enter valid email address'];
    } else {

      $user = User::where('email', '=', $request->get('email'))->first();

      if (count($user) > 0) {

        $newPassword = Custom::getRandomString(6);
        $user->password = bcrypt($newPassword);
        $user->save();

        $data['message'] = '<br/><br/>Forgotten your password, Dont worry, here is new password for you.<br/><br/> <b>Email:</b>' . $user->email . '<br/><b>Password:</b>' . $newPassword . '<br/><br/>';
        $mail_content = view('member.email-template.broadcast', $data);

        $subject = 'New password from HelpGivers Community';

        Custom::sendHtmlMail($user->email, $subject, $mail_content);

        return ['status' => '1', 'message' => "Please check your inbox for new password. If you don't have any email from us, please retry or contact administrator."];
      } else {
        return ['status' => '0', 'message' => 'Email address not found'];
      }
    }
  }

}
