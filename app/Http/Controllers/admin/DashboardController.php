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
use App\Manager;
use App\MemberLog;
use App\Country;
use App\Custom;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request) {

    // Users.
    $data['total_users'] = User::where('suspended', '=', '0')->count();
    $data['suspended_users'] = User::where('suspended', '=', '1')->count();
    $data['users_in_last_week'] = User::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->count();
    $data['users_in_30_days'] = User::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->count();

    // GH
    $data['total_gh'] = GH::where('id', '>', '0')->sum('amount');
    $data['total_approved_gh'] = GH::where([
                ['status', '=', 'approved'],
                ['pending_amount', '=', 0],
            ])->sum('amount');

    $data['total_ph'] = PH::where('id', '>', '0')->sum('amount');
    $data['total_approved_ph'] = GH::where([
                ['status', '=', 'approved'],
                ['pending_amount', '=', 0],
            ])->sum('amount');

    $data['recently_joined_members'] = User::limit(10)->orderBy('id', 'DESC')->get();

    return view('admin.dashboard.index', $data);
  }
}
