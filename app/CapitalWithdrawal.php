<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CapitalWithdrawal extends Model
{
    public $table = 'capital_withdrawals';

	public $fillable = [
        'user_id',
        'trader_id',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        // 'trader_id' => 'json',
        'amount' => 'double'
    ];

    public function get_user_details() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function get_trader_details() {
        return $this->hasOne('App\Models\Trader', 'id', 'trader_id');
    }
}
