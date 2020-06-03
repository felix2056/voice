<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadStatus extends Model
{
  protected $fillable = [
    'user_id', 'message_id'
  ];

  public function getPendingMessage($userId) {
    return $this->where('user_id', $userId)->count();
  }
}
