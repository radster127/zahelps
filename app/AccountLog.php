<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountLog extends Model
{
    protected $fillable = [
	    'user_id', 'log_type', 'comment', 'amount'
	];
	
	protected $table = 'account_log';

	public static function addLog($log_type, $comment, $amount, $user_id = 0) {
	    if ($user_id == 0) {
	      $user_id = Auth::user()->id;
	    }
	    self::create([
	        'user_id' => $user_id,
	        'log_type' => $log_type,
	        'comment' => $comment,
	        'amount' => $amount
	    ]);
	}
}
