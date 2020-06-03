<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Chatroom extends Model
{
    protected $fillable = ['user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
