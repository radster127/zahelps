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
use App\User;
use App\GH;
use App\PH;
use App\Pair;
use App\Setting;
use App\MemberLog;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function __construct() {
    $this->base_url = 'http://localhost/laravel/hg_plan/public/old-data/';
  }

  private function callCurl($url) {
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
    if (empty($buffer)) {
      return false;
    } else {
      return $buffer;
    }
  }

  public function users() {
    $response = $this->callCurl($this->base_url . 'users.php');

    $responseArr = json_decode($response, true);
    echo '<pre>';
    print_r($responseArr);
    echo '</pre>';
    //exit;


    if (count($responseArr) > 0) {
      foreach ($responseArr as $user) {

        $user_id = NULL;
        if ($user['referer'] != NULL) {
          $sponsor = User::where('username', '=', $user['referer'])->first();
          if ($sponsor) {
            $user_id = $sponsor->id;
          }
        }


        $userTemp = User::where('username', '=', $user['username'])->get();



        if (count($userTemp) == 0) {

          try {

            $joining_datetime = $user['joining_datetime'] != '' ? Carbon::createFromTimestamp($user['joining_datetime']) : '';
            $last_login_datetime = $user['last_login_datetime'] != '' ? Carbon::createFromTimestamp($user['last_login_datetime']) : '';
            $created_at = $user['created_at'] != '' ? Carbon::createFromTimestamp($user['created_at']) : '';
          } catch (Exception $e) {
            print_r($e);
          }


          $newUser = User::create([
                      'id' => $user['id'],
                      'user_type' => $user['user_type'],
                      'user_id' => $user_id,
                      'username' => $user['username'],
                      'password' => Hash::make(Custom::getRandomString(6)),
                      'ip_address' => $user['ip_address'],
                      'name' => $user['name'],
                      'email' => $user['email'],
                      'phone' => $user['phone'],
                      'avatar' => $user['avatar'],
                      'address' => $user['address'],
                      'city' => $user['city'],
                      'pincode' => $user['pincode'],
                      'country_id' => NULL,
                      'bank_name' => $user['bank_name'],
                      'bank_account_name' => $user['bank_account_name'],
                      'bank_account_number' => $user['bank_account_number'],
                      'bitcoin' => $user['bitcoin'],
                      'referals' => $user['referals'],
                      'joining_datetime' => $joining_datetime,
                      'last_login_datetime' => $last_login_datetime,
                      'last_login_ip_address' => $user['last_login_ip_address'],
                      'suspended' => $user['suspended'],
                      'facebook' => $user['facebook'],
                      'twitter' => $user['twitter'],
                      'account_balance' => $user['account_balance'],
                      'admin_commision' => $user['admin_commision'],
                      'member_commision' => $user['member_commision'],
                      'current_ph' => $user['current_ph'],
                      'status' => $user['status'],
                      'newsletter' => $user['newsletter'],
                      'created_at' => $created_at,
          ]);

          if ($user_id > 0) {
            //MemberLog::addLog(1, $user_id, $newUser->id);
          }

          //
        }
      }
    }
  }

  public function gh() {
    $response = $this->callCurl($this->base_url . 'gh.php');

    $responseArr = json_decode($response, true);
    /* echo '<pre>';
      print_r($responseArr);
      echo '</pre>'; */
    //exit;


    if (count($responseArr) > 0) {
      foreach ($responseArr as $gh_array) {

        $user_id = NULL;
        if ($gh_array['username'] != NULL) {
          $gh_user = User::where('username', '=', $gh_array['username'])->first();
          if ($gh_user) {
            $user_id = $gh_user->id;
          }
        }


        $ghTemp = GH::where('transaction_code', '=', $gh_array['transaction_code'])->get();



        if (count($ghTemp) == 0) {

          try {
            $lock_gh = $gh_array['lock_gh'] != '' ? Carbon::createFromTimestamp($gh_array['lock_gh']) : '';
            $created_at = $gh_array['created_at'] != '' ? Carbon::createFromTimestamp($gh_array['created_at']) : '';
          } catch (Exception $e) {
            print_r($e);
          }

          $gh_array['user_information']['id'] = $user_id;


          $array = [
              'old_id' => $gh_array['old_id'],
              'user_id' => $user_id,
              'transaction_code' => $gh_array['transaction_code'],
              'user_information' => json_encode($gh_array['user_information']),
              'amount' => $gh_array['amount'],
              'pending_amount' => $gh_array['pending_amount'],
              'lock_gh' => $lock_gh,
              'ip_address' => $gh_array['ip_address'],
              'status' => $gh_array['status'],
              'created_at' => $lock_gh,
          ];

          echo '<pre><h3>Array</h3>';

          print_r($array);
          echo '</pre>';


          $newGH = GH::create($array);
          //
        }
      }
    }
  }

  public function ph() {
    $response = $this->callCurl($this->base_url . 'ph.php');

    $responseArr = json_decode($response, true);
    /* echo '<pre>';
      print_r($responseArr);
      echo '</pre>';
      exit; */


    if (count($responseArr) > 0) {
      foreach ($responseArr as $ph_array) {

        $user_id = NULL;
        if ($ph_array['username'] != NULL) {
          $ph_user = User::where('username', '=', $ph_array['username'])->first();
          if ($ph_user) {
            $user_id = $ph_user->id;
          }
        }


        $phTemp = PH::where('transaction_code', '=', $ph_array['transaction_code'])->get();



        if (count($phTemp) == 0) {

          try {
            $lock_ph = $ph_array['lock_ph'] != '' ? Carbon::createFromTimestamp($ph_array['lock_ph']) : '';
            $created_at = $ph_array['created_at'] != '' ? Carbon::createFromTimestamp($ph_array['created_at']) : '';
          } catch (Exception $e) {
            print_r($e);
          }

          $ph_array['user_information']['id'] = $user_id;
          $ph_array['user_information']['phone'] = base64_decode($ph_array['user_information']['phone']);


          $array = [
              'old_id' => $ph_array['old_id'],
              'user_id' => $user_id,
              'transaction_code' => $ph_array['transaction_code'],
              //
              'profit_per_day_percentage' => '10',
              'profit_total_days' => '5',
              'profit_day_counter' => '5',
              //
              'user_information' => json_encode($ph_array['user_information']),
              'amount' => $ph_array['amount'],
              'pending_amount' => $ph_array['pending_amount'],
              'lock_ph' => $lock_ph,
              //
              'admin_commission_percentage' => 0,
              'admin_commission' => 0,
              //
              'ph_capital' => $ph_array['amount'],
              'ph_profit' => $ph_array['amount'] / 2,
              'profit_start_datetime' => $lock_ph,
              'profit_credited' => '1',
              'profit_credited_datetime' => Carbon::now(),
              //
              'ip_address' => $ph_array['ip_address'],
              'status' => $ph_array['status'],
              'created_at' => $lock_ph,
          ];

          echo '<pre><h3>Array</h3>';

          print_r($array);
          echo '</pre>';


          $newPH = PH::create($array);
          //
        }
      }
    }
  }

  public function pair() {
    $response = $this->callCurl($this->base_url . 'pair.php');

    $responseArr = json_decode($response, true);
    /* echo '<pre>';
      print_r($responseArr);
      echo '</pre>';
      exit; */


    if (count($responseArr) > 0) {
      foreach ($responseArr as $pair_array) {

        $ph_id = NULL;
        $gh_id = NULL;

        if ($pair_array['ph_id'] != '') {
          $ph = PH::where('old_id', '=', $pair_array['ph_id'])->first();
          if ($ph) {
            $ph_id = $ph->id;
          }
        }
        if ($pair_array['gh_id'] != '') {
          $gh = GH::where('old_id', '=', $pair_array['gh_id'])->first();
          if ($gh) {
            $gh_id = $gh->id;
          }
        }

        if ($ph_id != NULL && $gh_id != NULL) {

          $pairTemp = Pair::where('token', '=', $pair_array['token'])->get();

          $approved_on = $pair_array['approved_on'] != '' ? Carbon::createFromTimestamp($pair_array['approved_on']) : '';

          $array = [
              'ph_id' => $ph_id,
              'gh_id' => $gh_id,
              'approved_on' => $approved_on,
              'reason' => $pair_array['reason'] != '0' ? $pair_array['reason'] : '',
              'status' => $pair_array['status'],
              'payment_type' => $pair_array['payment_type'],
              'amount' => $pair_array['amount'],
              'token' => $pair_array['token'],
              'proof_picture' => base64_decode($pair_array['proof_picture']),
          ];

          echo '<pre>';
          print_r($array);
          echo '</pre>';

          $newPair = Pair::create($array);
        }
      }
    }
  }

  public function expiredPair() {
    $response = $this->callCurl($this->base_url . 'expired-pair.php');

    $responseArr = json_decode($response, true);
    /* echo '<pre>';
      print_r($responseArr);
      echo '</pre>';
      exit; */


    if (count($responseArr) > 0) {
      foreach ($responseArr as $pair_array) {

        $ph_id = NULL;
        $gh_id = NULL;

        if ($pair_array['ph_id'] != '') {
          $ph = PH::where('old_id', '=', $pair_array['ph_id'])->first();
          if ($ph) {
            $ph_id = $ph->id;
          }
        }
        if ($pair_array['gh_id'] != '') {
          $gh = GH::where('old_id', '=', $pair_array['gh_id'])->first();
          if ($gh) {
            $gh_id = $gh->id;
          }
        }

        if ($ph_id != NULL && $gh_id != NULL) {

          $pairTemp = Pair::where('token', '=', $pair_array['token'])->get();

          $approved_on = $pair_array['approved_on'] != '' ? Carbon::createFromTimestamp($pair_array['approved_on']) : '';
          $expired_on = $pair_array['expired_on'] != '' ? Carbon::createFromTimestamp($pair_array['expired_on']) : '';

          $array = [
              'ph_id' => $ph_id,
              'gh_id' => $gh_id,
              'expired_on' => $expired_on,
              'approved_on' => $approved_on,
              'reason' => $pair_array['reason'] != '0' ? $pair_array['reason'] : '',
              'status' => $pair_array['status'],
              'payment_type' => $pair_array['payment_type'],
              'amount' => $pair_array['amount'],
              'token' => $pair_array['token'],
              'proof_picture' => base64_decode($pair_array['proof_picture']),
          ];

          echo '<pre>';
          print_r($array);
          echo '</pre>';

          $newPair = Pair::create($array);
        }
      }
    }
  }

  public function correctGH() {

    $gh_list = GH::all();

    $ghListArray = [];

    if (count($gh_list) > 0) {
      foreach ($gh_list as $gh_item) {

        // check and update status and pending amount
        Custom::updateGHStatusAndPendingAmount($gh_item);
      }
    }

  }

  public function correctPH() {

    $ph_list = PH::all();

    $phListArray = [];

    if (count($ph_list) > 0) {
      foreach ($ph_list as $ph_item) {

        $pairCal = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');

        // check and update status and pending amount
        Custom::updatePHStatusAndPendingAmount($ph_item);
      }
    }

  }
}
