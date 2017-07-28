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
use App\Custom;
use App\User;
use App\MemberLog;
use App\PH;
use App\GH;
use App\Pair;

class DashboardController extends Controller
{
    //
    public function __construct() {
	    $this->ph_settings = Custom::getSettings('provide_help');
	    $this->gh_settings = Custom::getSettings('get_help');
		$this->web_settings = Custom::getSettings('web');
	}

	public function index(Request $request) {

        $data['ph_settings'] = $this->ph_settings;
        $data['gh_settings'] = $this->gh_settings;
        $data['web_settings'] = $this->web_settings;

        // My Pending PH Requests
        $data['ph_pending_list'] = PH::myPendingPH();

        // My Pending GH Requests
        $data['gh_pending_list'] = GH::myPendingGH();


        // my paired but not completed PH requests.
        $data['ph_paired_list'] = Pair::myPairedPH();
        $data['gh_paired_list'] = Pair::myPairedGH();


        // get total successful PH done by user.
        $data['ph_total'] = PH::where('user_id', '=', Auth::user()->id)
                ->where('status', '=', 'approved')
                ->where('pending_amount', '=', 0)
                ->select('user_id', DB::raw('SUM(amount) as total_ph'))
                ->groupBy('user_id')
                ->first();

        // get total successful GH done by user.
        $data['gh_total'] = GH::where('user_id', '=', Auth::user()->id)
                ->where('status', '=', 'approved')
                ->where('pending_amount', '=', 0)
                ->select('user_id', DB::raw('SUM(amount) as total_gh'))
                ->groupBy('user_id')
                ->first();

        $data['user'] = Auth::user();

        $data['total_referrals'] = MemberLog::where('user_id', '=', Auth::user()->id)->count();
        $data['total_direct_referrals'] = User::where('user_id', '=', Auth::user()->id)->count();
        //dd($data);

        return view('member.dashboard.index', $data);
    }
	


}
