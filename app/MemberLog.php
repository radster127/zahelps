<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\User;

class MemberLog extends Model
{
    //
    protected $table = 'member_log';
  protected $fillable = [
      'level_number', 'user_id', 'member_id'
  ];

  public static function addLog($level_number, $user_id, $member_id) {

    self::create([
        'level_number' => $level_number,
        'user_id' => $user_id,
        'member_id' => $member_id,
    ]);

    $parentUser = User::find($user_id);

    if ($parentUser->user_id > 0) {
      $level_number++;
      self::addLog($level_number, $parentUser->user_id, $member_id);
    }
  }
}
