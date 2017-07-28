<?php

namespace App;

use \Image;
use \App\SystemActivityLog;
use Illuminate\Support\Facades\Auth;
use \App\Setting;
use \App\PhProfitHistory;
use \App\AccountLog;
use \App\User;
use \App\PH;
use \App\GH;
use \App\Pair;
use \Carbon\Carbon;

class Custom 
{
    public static function sendHtmlMail($to, $subject, $mail_content, $from = '') {
    $headers = '';
    if ($from != '') {
      $headers .= "From: " . strip_tags($from) . "\r\n";
      $headers .= "Reply-To: " . strip_tags($from) . "\r\n";
    }

    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($to, $subject, $mail_content, $headers)) {
      return 'mail_sent';
    } else {
      return 'error';
    }
  }

  // for table heading sorting link
  public static function getSortingLink($link, $heading, $field, $curSortBy = '', $curSortOrder = 'asc', $search_field = '', $search_val = '', $extra_params = '') {

    $qs = '?';
    if (strpos($link, '?') != false) {
      $qs = '&';
    }

    $caret = '<i class="fa fa-angle-up"></i>';

    if ($field != $curSortBy) {
      $link .= $qs . 'sortBy=' . $field . '&sortOrd=asc';
      $caret = '';
    } elseif ($field == $curSortBy) {
      if ($curSortOrder == "asc") {
        $link .= $qs . 'sortBy=' . $field . '&sortOrd=desc';
      } elseif ($curSortOrder == "desc") {
        $link .= $qs . 'sortBy=' . $field . '&sortOrd=asc';
        $caret = '<i class="fa fa-angle-down"></i>';
      } else {
        $link .= $qs . 'sortBy=' . $field . '&sortOrd=asc';
      }
    }

    if ($search_field != "" && $search_val != "") {
      $link .= '&search_field=' . $search_field . "&search_text=" . $search_val;
    }

    if ($extra_params != "") {
      $link .= "&" . $extra_params;
    }


    return '<a href="' . $link . '">' . $heading . ' ' . $caret . '</a>';
  }

  public static function getFilename($fullpath, $uploaded_filename) {
    $count = 1;
    $new_filename = $uploaded_filename;
    $firstinfo = pathinfo($fullpath);

    while (file_exists($fullpath)) {
      $info = pathinfo($fullpath);
      $count++;
      $new_filename = $firstinfo['filename'] . '(' . $count . ')' . '.' . $info['extension'];
      $fullpath = $info['dirname'] . '/' . $new_filename;
    }

    return $new_filename;
  }

  public static function createThumnails($uploadPath, $filename) {
    $sizes = env('APP_IMAGE_THUMB_SIZES');
    $sizes = explode(',', $sizes);
    $orgFile = $uploadPath . $filename;

    foreach ($sizes as $size) {
      $temp = explode('X', $size);
      $thumbFile = $uploadPath . "thumb_" . $size . "_" . $filename;

      $w = isset($temp[0]) ? $temp[0] : 100;
      $h = isset($temp[1]) ? $temp[1] : 100;

      Image::make($orgFile)
              ->resize($w, null, function ($constraint) {
                $constraint->aspectRatio();
              })
              ->save($thumbFile);
    }
  }

  public static function removeUserAvatar($user) {

    $filename = $user->avatar;
    $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . 'members' . DIRECTORY_SEPARATOR . $user->id;
    $baseFilePath = public_path() . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR;

    if (is_file($baseFilePath . $filename)) {
      unlink($baseFilePath . $filename);
    }
    // remove thumbnails
    $sizes = env('APP_IMAGE_THUMB_SIZES');
    $sizes = explode(',', $sizes);

    if (is_array($sizes) && count($sizes) > 0) {
      foreach ($sizes as $size) {
        $filepath = $baseFilePath . 'thumb_' . $size . '_' . $filename;
        if (is_file($filepath)) {
          unlink($filepath);
        }
      }
    }
  }

  public static function removeProofPicture($pair) {

    $filename = $pair->proof_picture;
    $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . 'payment_proof' . DIRECTORY_SEPARATOR . $pair->id;
    $baseFilePath = public_path() . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR;

    if (is_file($baseFilePath . $filename)) {
      unlink($baseFilePath . $filename);
    }
    // remove thumbnails
    $sizes = env('APP_IMAGE_THUMB_SIZES');
    $sizes = explode(',', $sizes);

    if (is_array($sizes) && count($sizes) > 0) {
      foreach ($sizes as $size) {
        $filepath = $baseFilePath . 'thumb_' . $size . '_' . $filename;
        if (is_file($filepath)) {
          unlink($filepath);
        }
      }
    }
  }

  // to generate random string
  public static function getRandomString($len = 30) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    //$chars = "0123456789";
    $r_str = "";
    for ($i = 0; $i < $len; $i++)
      $r_str .= substr($chars, rand(0, strlen($chars)), 1);

    if (strlen($r_str) != $len) {
      $r_str .= self::getRandomString($len - strlen($r_str));
    }

    return $r_str;
  }

  public static function getListParams($request, $extras = []) {
    $list_params = array(
        'from_date' => $request->get('from_date'),
        'to_date' => $request->get('to_date'),
        'search_field' => $request->get('search_field'),
        'search_text' => $request->get('search_text'),
        'sort_by' => $request->get('sortBy'),
        'sort_order' => $request->get('sortOrd'),
    );

    if (count($extras)) {
      foreach ($extras as $item) {

        if ($request->has($item)) {
          $list_params[$item] = $request->get($item);
        }
      }
    }

    return $list_params;
  }

  public static function showDateTime($datetime, $showFormat, $currentFormat = 'Y-m-d H:i:s') {
    if ($datetime != '') {
      return \Carbon\Carbon::createFromFormat($currentFormat, $datetime)->format($showFormat);
    }
    return '';
  }

  public static function getSettings($setting_type = 'web') {
    $settings = Setting::where('setting_type', '=', $setting_type)->get();
    $settingArr = [];
    if (count($settings) > 0) {
      foreach ($settings as $item) {
        $settingArr[$item->name] = $item->value;
      }
    }
    return $settingArr;
  }

  public static function checkForProfitDays($ph_item) {

   /* if ($ph_item->profit_total_days == $ph_item->profit_day_counter && $ph_item->pending_amount == 0 && $ph_item->profit_credited == '0') {*/


      $notApprovedPairs = Pair::where([
                  ['ph_id', '=', $ph_item->id],
                  ['status', '!=', 'approved'],
              ])->count();

      if ($notApprovedPairs <= 0) {
        $user = User::find($ph_item->user_id);

        $ph_item->profit_credited = '1';
        //$ph_item->ph_profit = (($ph_item->ph_capital - $ph_item->pending_amount) / 2) ;
        $ph_item->profit_credited_datetime = Carbon::now();
        $ph_item->save();


        $user->account_balance += ($ph_item->ph_capital + $ph_item->ph_profit );
        $user->save();

        $commission = $ph_item->ph_capital + $ph_item->ph_profit;

        // Add Account log
        AccountLog::addLog('credit', 'PH(#' . $ph_item->transaction_code . ') Commission', $commission, $user->id);
      }
    }
  /*}*/

  public static function removePair($pair_item) {

    // make frozen PH request
    $ph_item = PH::find($pair_item->ph_id);
    if ($ph_item) {
      $ph_item->pending_amount += $pair_item->amount;
      $ph_item->status = 'frozen';

      if ($ph_item->pending_amount > $ph_item->amount) {
        $ph_item->pending_amount = $ph_item->amount;
      }
      $ph_item->save();
    }

    // make GH Request pending
    $gh_item = GH::find($pair_item->gh_id);
    if ($gh_item) {
      $gh_item->pending_amount += $pair_item->amount;
      $gh_item->status = 'pending';
      if ($gh_item->pending_amount > $gh_item->amount) {
        $gh_item->pending_amount = $gh_item->amount;
      }
      $gh_item->save();
    }

    // suspend PH User
    $ph_user = User::find($ph_item->user_id);
    if ($ph_user) {
      $ph_user->suspended = '1';
      $ph_user->save();
    }


    // remove pair from db
    $pair_item->delete();
  }

  public static function approvePair($pair_item) {

    $pair_item->status = 'approved';
    $pair_item->save();


    // Update PH status
    $PHPairCnt = Pair::where([
                ['ph_id', '=', $pair_item->ph_id],
                ['status', '!=', 'approved'],
            ])->count();

    $ph_item = PH::find($pair_item->ph_id);
    if ($PHPairCnt == 0 && $ph_item->pending_amount <= 0) {
      $ph_item->status = 'approved';
      $ph_item->save();
    }

    // Update GH status
    $GHPairCnt = Pair::where([
                ['gh_id', '=', $pair_item->gh_id],
                ['status', '!=', 'approved'],
            ])->count();
    $gh_item = GH::find($pair_item->gh_id);
    if ($GHPairCnt == 0 && $gh_item->pending_amount <= 0) {
      $gh_item->status = 'approved';
      $gh_item->save();
    }


    self::checkForProfitDays($ph_item);
    //dd($pair_item->PH->user->user_id);

    if ($pair_item->PH->user->user_id > 0) {
      $level_number = 1;
      self::givePHProfitToSponsor($pair_item, $pair_item->PH->user->user_id, $level_number);
      self::givePHProfitToDirector($pair_item, $pair_item->PH->user->user_id, $level_number);
    }
  }

  public static function givePHProfitToSponsor($pair_item, $sponsor_id, $level_number = 1) {
    $profit_settings = self::getSettings('profit');

    //dd($profit_settings);

    $sponsor_user = User::find($sponsor_id);

    if ($level_number >= 1 && $level_number <= 10) {

      // add account balance
      $ph_amount = $pair_item->PH->amount;
      $profit_percentage = $profit_settings['member_commission_level_' . $level_number];
      if ($profit_percentage > 0 && $ph_amount > 0) {
        $sponsor_profit = $ph_amount * $profit_percentage / 100;

        $sponsor_user->member_commision += $sponsor_profit;
        $sponsor_user->save();

        // Add Account log
        AccountLog::addLog('debit', 'Member PH(#' . $pair_item->PH->transaction_code . ') Commission at Level: ' . $level_number, $sponsor_profit, $sponsor_user->id);

        // add PH Profit history
        PhProfitHistory::create([
            'ph_id' => $pair_item->PH->id,
            'user_id' => $sponsor_user->id,
            'level_number' => $level_number,
            'profit_percentage' => $profit_percentage,
            'profit_amount' => $sponsor_profit
        ]);
      }

      if ($sponsor_user->user_id > 0) {
        $level_number++;
        self::givePHProfitToSponsor($pair_item, $sponsor_user->user_id, $level_number);
      }
    } else {
      return false;
    }
  }

  public static function givePHProfitToDirector($pair_item, $sponsor_id, $level_number = 1) {
    $profit_settings = self::getSettings('profit');

    //dd($profit_settings);

    $sponsor_user = User::find($sponsor_id);

    if ($level_number >= 1 && $level_number <= 20) {

      $profit_percentage = 0;
      // check director level of sponsor
      if ($sponsor_user->manager_id == 1 && ($level_number >= 1 && $level_number <= 8)) {
        // Director
        $profit_percentage = $profit_settings['director_commission_level_' . $level_number];
      } elseif ($sponsor_user->manager_id == 2 && ($level_number >= 1 && $level_number <= 10)) {
        // Sr. Director
        $profit_percentage = $profit_settings['senior_director_commission_level_' . $level_number];
      } elseif ($sponsor_user->manager_id == 3 && ($level_number >= 1 && $level_number <= 15)) {
        // Principal Director
        $profit_percentage = $profit_settings['principal_director_commission_level_' . $level_number];
      } elseif ($sponsor_user->manager_id == 4 && ($level_number >= 1 && $level_number <= 20)) {
        // Chief Director
        $profit_percentage = $profit_settings['chief_director_commission_level_' . $level_number];
      }

      // add account balance
      $ph_amount = $pair_item->PH->amount;

      if ($profit_percentage > 0 && $ph_amount > 0) {
        $sponsor_profit = $ph_amount * $profit_percentage / 100;
        $sponsor_user->member_commision += $sponsor_profit;
        $sponsor_user->save();

        // Add Account log
        AccountLog::addLog('debit', $sponsor_user->manager->name . ' Commission PH(#' . $pair_item->PH->transaction_code . ') Commission at Level: ' . $level_number, $sponsor_profit, $sponsor_user->id);

        // add PH Profit history
        PhProfitHistory::create([
            'ph_id' => $pair_item->PH->id,
            'user_id' => $sponsor_user->id,
            'manager_id' => $sponsor_user->manager_id,
            'level_number' => $level_number,
            'profit_percentage' => $profit_percentage,
            'profit_amount' => $sponsor_profit
        ]);
      }

      if ($sponsor_user->user_id > 0) {
        $level_number++;
        self::givePHProfitToDirector($pair_item, $sponsor_user->user_id, $level_number);
      }
    } else {
      return false;
    }
  }

  public static function createPair($gh_item, $ph_item, $amount) {
    Pair::create([
        'gh_id' => $gh_item->id,
        'ph_id' => $ph_item->id,
        'expired_on' => Carbon::now()->addDays(2),
        'amount' => $amount,
        'token' => Custom::getRandomString(16),
    ]);

    $gh_item->status = 'paired';
    $gh_item->pending_amount = $gh_item->pending_amount - $amount;
    $gh_item->save();

    $ph_item->status = 'paired';
    $ph_item->pending_amount = $ph_item->pending_amount - $amount;
    $ph_item->save();
  }

  public static function updateGHStatusAndPendingAmount($gh_item) {
    // check for status
    $GHPairCnt = Pair::where([
                ['gh_id', '=', $gh_item->id],
                ['status', '!=', 'approved'],
            ])->count();

    if ($GHPairCnt == 0 && $gh_item->pending_amount <= 0) {
      $gh_item->status = 'approved';
    } else {
      $pairCnt = Pair::where([
                  ['gh_id', '=', $gh_item->id],
              ])->count();

      if ($pairCnt > 0) {
        $gh_item->status = 'paired';
      } else {
        $gh_item->status = 'pending';
      }
    }
    // update PH Pending Amount
    $pairCal = Pair::where('gh_id', '=', $gh_item->id)->sum('amount');
    $deduction = $gh_item->amount - $pairCal;
    if ($deduction < 0)
      $deduction = 0;
    $gh_item->pending_amount = $deduction;

    // final save
    $gh_item->save();
  }

  public static function updatePHStatusAndPendingAmount($ph_item) {

    // check for status
    if ($ph_item->status != 'frozen') {
      $PHPairCnt = Pair::where([
                  ['ph_id', '=', $ph_item->id],
                  ['status', '!=', 'approved'],
              ])->count();

      if ($PHPairCnt == 0 && $ph_item->pending_amount <= 0) {
        $ph_item->status = 'approved';
      } else {
        $pairCnt = Pair::where([
                    ['ph_id', '=', $ph_item->id],
                ])->count();

        if ($pairCnt > 0) {
          $ph_item->status = 'paired';
        } else {
          $ph_item->status = 'pending';
        }
      }

      // update PH Pending Amount
      $pairCal = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');
      $deduction = $ph_item->amount - $pairCal;
      if ($deduction < 0)
        $deduction = 0;
      $ph_item->pending_amount = $deduction;

      // final save
      $ph_item->save();
    }
  }
}
