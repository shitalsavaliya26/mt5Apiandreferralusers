<?php

namespace App\Models;

use Eloquent as Model;

class TraderHistory extends Model
{
    public $timestamps = true;

    public $table = 'traders_history';

    public $fillable = [
        'user_id',
        'trader_id',
        'amount',
        'status',
        'start_date',
        'end_date'
    ];

    public function traders()
    {
        return $this->hasOne(Trader::class, 'id', 'trader_id');
    }
    public function get_user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
