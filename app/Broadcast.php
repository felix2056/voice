<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Broadcast extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'source', 'created_at', 'updated_at'
    ];

    protected $appends = ['source_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSourceUrlAttribute()
    {
        return '/storage/broadcasts/' . $this->source;
        
    }
}
