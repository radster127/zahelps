<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models
use App\Setting;

class SettingController extends Controller
{
    public function __construct() {

    // Links
    $this->list_url = 'settings';

    // View
    $this->veiw_base = 'admin.settings';
  }

  public function webSettings(Request $request) {
    $data['settings'] = Setting::where('setting_type', '=', 'web')->orderBy('setting_order')->get();
    $data['pageTitle'] = 'Web Settings';
    return view($this->veiw_base . '.index', $data);
  }

  public function ghSettings(Request $request) {
    $data['settings'] = Setting::where('setting_type', '=', 'get_help')->orderBy('setting_order')->get();
    $data['pageTitle'] = 'Get Help Settings';
    return view($this->veiw_base . '.index', $data);
  }

  public function phSettings(Request $request) {
    $data['settings'] = Setting::where('setting_type', '=', 'provide_help')->orderBy('setting_order')->get();
    $data['pageTitle'] = 'Provide Help Settings';
    return view($this->veiw_base . '.index', $data);
  }

  public function profitSettings(Request $request) {
    $data['settings'] = Setting::where('setting_type', '=', 'profit')->orderBy('setting_order')->get();
    $data['pageTitle'] = 'Profit Settings';
    return view($this->veiw_base . '.index', $data);
  }

  public function update(Request $request) {
    if (count($request->all()) > 0) {
      foreach ($request->get('settings') as $key => $val) {
        $settingObj = Setting::find($key);
        $settingObj->update(['value' => $val]);
      }
    }
    session()->flash('success_message', 'Settings has been updated successfuly');
    return back();
  }
}
