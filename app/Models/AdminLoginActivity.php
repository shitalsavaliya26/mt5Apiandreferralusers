<?php

namespace App\Models;

use DateTime;
use Eloquent as Model;

/**
 * Class TopupFund
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property datetime login_at
 * @property string ip_address
 */
class AdminLoginActivity extends Model
{
    public $table = 'admin_login_activities';

    public $fillable = [
        'user_id',
        'login_at',
        'ip_address',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'login_at' => 'datetime',
        'ip_address' => 'string',
    ];

}
