<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class Withdraw
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property string amount
 * @property integer status
 * @property text remarks
 */
class Withdraw extends Model
{
    public $table = 'withdraws';

    public $fillable = [
        'user_id',
        'amount',
        'withdrawal_fees',
        'remarks',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'amount' => 'string',
        'status' => 'integer'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
