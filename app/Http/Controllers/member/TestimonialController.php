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
use App\Testimonial;
use App\Custom;

class TestimonialController extends Controller
{
    public function __construct() {
    $this->base_view = 'member.testimonials.';
  }

  public function create() {
    $data = [];
    return view($this->base_view . 'create', $data);
  }

  public function store(Request $request) {

    $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required'
    ]);

    if ($validator->fails()) {
      return redirect('member/letter-of-happiness')
                      ->withErrors($validator)
                      ->withInput();
    } else {

      $requestArr = $request->all();
      $requestArr['user_id'] = Auth::user()->id;

      $testimonial = Testimonial::create($requestArr);

      session()->flash('success_message', 'Letter of happiness has been sent to admin.');
      return redirect('member/letter-of-happiness');
    }
  }
}
