<?php

namespace App\Http\Controllers\cron;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// Models [start]
use App\Custom;
use App\PH;
use App\Setting;
use App\PhProfitHistory;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PHController extends Controller
{
    public function __construct() {
    $this->ph_settings = Custom::getSettings('provide_help');
    $this->profit_settings = Custom::getSettings('profit');
  }

  public function calculatePHProfit(Request $requtest) {

    // Find PH of pending profit.

    $ph_list = PH::whereIn('status', ['pending', 'paired', 'approved'])
            ->where(DB::raw("`profit_total_days`"), '>', DB::raw("`profit_day_counter`"))
            ->where('profit_start_datetime', '<', \Carbon\Carbon::now())
            //->toSql()
            ->get();


    if (count($ph_list) > 0) {
      foreach ($ph_list as $item) {

        $ph_capital = $item->ph_capital;
        $profit_per_day_percentage = $item->profit_per_day_percentage;
        $profit_day_counter = $item->profit_day_counter;

        $profit_per_day = $ph_capital * $profit_per_day_percentage / 100;
        $total_profit = $item->ph_profit + $profit_per_day;
        $item->ph_profit = $total_profit;
        $item->profit_day_counter = ++$profit_day_counter;

        $item->save();

        // ad history
        PhProfitHistory::create([
            'ph_id' => $item->id,
            'user_id' => $item->user_id,
            'level_number' => 0,
            'profit_percentage' => $profit_per_day_percentage,
            'profit_amount' => $profit_per_day
        ]);

        Custom::checkForProfitDays($item);
        
      }
    }

    return count($ph_list) . ' rows updated';
  }
}
