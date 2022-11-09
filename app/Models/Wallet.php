<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Wallet
 * @package App\Models
 * @version January 30, 2020, 9:42 am UTC
 *
 * @property string name
 */
class Wallet extends Model
{
    public $table = 'wallets';

    public $fillable = [
        'user_id',
        'total_balance'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'total_balance' => 'required'
    ];
}
