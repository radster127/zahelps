<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
      'message_type', 'from_id', 'to_id', 'pair_id',
      'subject', 'message', 'is_read', 'read_at'
  ];
  protected $table = 'messages';

  public static function sendPairMessage($array) {
    self::create([
        'message_type' => 'pair_message',
        'pair_id' => $array['pair_id'],
        'from_id' => $array['from_id'],
        'to_id' => $array['to_id'],
        'message' => $array['message'],
    ]);
  }

  public function from() {
    return $this->belongsTo('\App\User', 'from_id');
  }

  public function to() {
    return $this->belongsTo('\App\User', 'to_id');
  }
}
