<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MemberMiddleware
{
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }
      
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next) {

    if ($this->auth->guest()) {
      if ($request->ajax()) {
        return response('Unauthorized.', 401);
      } else {
        return redirect()->guest('/member/login');
      }
    }

    if (!Auth::user()->isActive()) {
      Auth::logout();
      session()->flash('error_message', 'Your account is not active, Kindly contact admin.');
      return redirect()->guest('/member/login');
    }

    return $next($request);
  }
}
