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
use App\MemberLog;
use App\PH;
use App\GH;
use App\Pair;
use App\Setting;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PairController extends Controller
{
    public function expirePair() {

    // find Pairs which are expired
    $pairs = Pair::where('status', '=', 'paired')
            ->where('payment_type', '=', 'pending')
            ->where('expired_on', '<=', Carbon::now())
            ->get();

    //dd($pairs->toArray());

    if (count($pairs) > 0) {
      foreach ($pairs as $pair) {
        //
        Custom::removePair($pair);
      }
    }

    return count($pairs) . ' pairs has been expired.';
  }

  public function autoApprovePair() {

    // find Pairs which are expired
    $pairs = Pair::where('status', '=', 'paired')
            ->where('payment_type', '!=', 'pending')
            ->where('auto_approved_on', '<=', Carbon::now())
            ->get();

    dd($pairs->toArray());

    if (count($pairs) > 0) {
      foreach ($pairs as $pair) {
        //
        Custom::approvePair($pair);
      }
    }

    return 'test';
  }

  public function makePair() {

    $this->findPairs();
    return;
  }

  public function findPairs() {
    $gh_array = GH::whereIn('status', ['pending', 'paired', 'rejected'])
            ->where('pending_amount', '>', 0)
            ->where('is_freeze', '=', '0')
            ->where('lock_gh', '<', \Carbon\Carbon::now())
            ->orderBy('pending_amount', 'DESC')
            ->limit(50)
            ->get()
    ;

    //dd($gh_array->toArray());

    foreach ($gh_array as $gh_item) {
      $this->findExactPH($gh_item);
      sleep(1);
    }

    /* echo Carbon::now();
      sleep(1);
      echo Carbon::now(); */

    //return 'test';

    unset($gh_array);

    $gh_array = GH::whereIn('status', ['pending', 'paired', 'rejected'])
            ->where('pending_amount', '>', 0)
            ->where('is_freeze', '=', '0')
            ->where('lock_gh', '<', \Carbon\Carbon::now())
            ->orderBy('pending_amount', 'DESC')
            ->limit(50)
            ->get()
    ;

    foreach ($gh_array as $gh_item) {
      $this->findPH($gh_item);
      sleep(1);
    }


    echo '<pre>';
    print_r($gh_array->toArray());
    echo '</pre>';
  }

  private function findPH($gh_item, $callCounter = 0) {

    if ($callCounter < 3) {
      $gh_item_id = $gh_item->id;

      // get sum of all GH pairs
      $ghPairSum = Pair::where('gh_id', '=', $gh_item_id)->sum('amount');


      if ($gh_item->pending_amount > 0 && $ghPairSum < $gh_item->amount) {


        $ph_item = PH::where('pending_amount', '>', '0')
                ->where('lock_ph', '<', \Carbon\Carbon::now())
                ->where('is_freeze', '=', '0')
                ->whereIn('status', ['pending', 'paired'])
                ->orderBy('pending_amount', 'DESC')
                ->first();

        //dd($ph_item->toArray());

        if ($ph_item) {

          $amount = 0;


          if ($gh_item->pending_amount < $ph_item->pending_amount) {
            $amount = $gh_item->pending_amount;
          } elseif ($gh_item->pending_amount > $ph_item->pending_amount) {
            $amount = $ph_item->pending_amount;
          }



          if ($amount > 0) {
            $phPairSum = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');
            if ($phPairSum < $ph_item->amount) {
              $this->addPair($gh_item, $ph_item, $amount);
            } else {
              $this->updatePHPendingAmount($ph_item);
            }
          }

          $gh_item_temp = Gh::find($gh_item_id);

          if ($gh_item_temp->pending_amount > 0) {
            $callCounter++;
            sleep(1);
            $this->findPH($gh_item_temp, $callCounter);
          }
        }
      } else {
        $this->updateGHPendingAmount($gh_item);
      }
    }  // $callCounter < 3
  }

  private function findExactPH($gh_item) {


    $gh_item_id = $gh_item->id;

    // get sum of all GH pairs
    $ghPairSum = Pair::where('gh_id', '=', $gh_item_id)->sum('amount');

    if ($gh_item->pending_amount > 0 && $ghPairSum < $gh_item->amount) {

      // try to find exact amount
      $exact_ph_item = PH::whereIn('status', ['pending', 'paired'])
              ->where('lock_ph', '<', \Carbon\Carbon::now())
              ->where('is_freeze', '=', '0')
              ->where('pending_amount', '=', $gh_item->pending_amount)
              ->first();

      if ($exact_ph_item) {

        $phPairSum = Pair::where('ph_id', '=', $exact_ph_item->id)->sum('amount');

        if ($phPairSum < $exact_ph_item->amount) {
          $this->addPair($gh_item, $exact_ph_item, $gh_item->pending_amount);
        }
      }
    } else {
      $this->updateGHPendingAmount($gh_item);
    }
  }

  private function addPair($gh_item, $ph_item, $amount) {

    $pendingPHAmount = $ph_item->pending_amount - $amount;
    $pendingGHAmount = $gh_item->pending_amount - $amount;

    //$sumOfPHPair = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');
    //$sumOfGHPair = Pair::where('gh_id', '=', $gh_item->id)->sum('amount');

    if ($pendingPHAmount >= 0 && $pendingGHAmount >= 0) {

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
      
      //updata status and pending_amount of GH
      Custom::updateGHStatusAndPendingAmount($gh_item);

      $ph_item->status = 'paired';
      $ph_item->pending_amount = $ph_item->pending_amount - $amount;
      $ph_item->save();
      
      //updata status and pending_amount of PH
      Custom::updatePHStatusAndPendingAmount($ph_item);
    }
  }

  public function updateGHPendingAmount($gh_item) {

    $ghPairSum = Pair::where('gh_id', '=', $gh_item->id)->sum('amount');
    if ($ghPairSum > $gh_item->amount) {
      $gh_item->pending_amount = 0;
      $gh_item->save();
    } else {
      $gh_item->pending_amount = $gh_item->amount - $ghPairSum;
      $gh_item->save();
    }
  }

  public function updatePHPendingAmount($ph_item) {

    $phPairSum = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');
    if ($phPairSum > $ph_item->amount) {
      $ph_item->pending_amount = 0;
      $ph_item->save();
    } else {
      $ph_item->pending_amount = $ph_item->amount - $phPairSum;
      $ph_item->save();
    }
  }

  
  public function test() {
    echo Carbon::createFromTimestamp('1444466788');
    exit;
    if (mail('ajay.makwana87@gmail.com', 'Hello Ajay', 'Hello Ajay it is urgent. So call me.')) {
      echo 'mail sent';
    } else {
      echo 'mail not sent';
    }
  }

  public function memberLog() {
    $userList = User::all();

    if (count($userList) > 0) {
      foreach ($userList as $user) {

        if ($user->user_id > 0) {
          //MemberLog::addLog(1, $user->user_id, $user->id);
        }
      }
    }
  }

  public function removeDuplicatePair() {

    $ph_list = PH::where('amount', '<', DB::raw('(select sum(tb_pair.amount) from tb_pair where tb_pair.ph_id = tb_ph.id)'))->orderBy('id', 'DESC')->get();

    echo '<pre>';
    print_r($ph_list->toArray());
    //exit;

    if (count($ph_list)) {
      foreach ($ph_list as $ph_item) {

        //find paired and pending pairs.
        $pairItems = Pair::where(
                        [
                            ['ph_id', '=', $ph_item->id],
                            ['status', '=', 'paired'],
                            ['payment_type', '=', 'pending'],
                        ]
                )->delete();

        $phPairSum = Pair::where('ph_id', '=', $ph_item->id)->sum('amount');

        if ($phPairSum >= $ph_item->amount) {
          $ph_item->pending_amount = 0;
          $ph_item->save();
        } elseif ($phPairSum < $ph_item->amount) {
          $ph_item->pending_amount = $ph_item->amount - $phPairSum;
          $ph_item->save();
        }
      }
    }
  }

  public function removeDuplicatePair2() {

    $gh_list = GH::where('amount', '<', DB::raw('(select sum(tb_pair.amount) from tb_pair where tb_pair.gh_id = tb_gh.id)'))->orderBy('id', 'DESC')->get();

    echo '<pre>';
    print_r($gh_list->toArray());
    //exit;

    if (count($gh_list)) {
      foreach ($gh_list as $gh_item) {

        //find paired and pending pairs.
        $pairItems = Pair::where(
                        [
                            ['gh_id', '=', $gh_item->id],
                            ['status', '=', 'paired'],
                            ['payment_type', '=', 'pending'],
                        ]
                )->delete();

        $ghPairSum = Pair::where('gh_id', '=', $gh_item->id)->sum('amount');

        if ($ghPairSum >= $gh_item->amount) {
          $gh_item->pending_amount = 0;
          $gh_item->save();
        } elseif ($ghPairSum < $gh_item->amount) {
          $gh_item->pending_amount = $gh_item->amount - $ghPairSum;
          $gh_item->save();
        }
      }
    }
  }
}
