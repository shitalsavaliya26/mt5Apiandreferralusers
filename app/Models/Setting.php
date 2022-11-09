<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Setting
 * @package App\Models
 * @version January 2, 2020, 12:00 pm UTC
 *
 * @property string admin_email
 * @property string withdraw_fees
 * @property string withdraw_from_day
 * @property string withdraw_to_day
 * @property integer allow_first_withdraw
 * @property integer minimum_withdraw_amount
 * @property integer profit_sharing_commision_l1
 * @property integer profit_sharing_commision_l2
 * @property integer profit_sharing_commision_l3
 */
class Setting extends Model
{

    public $table = 'settings';

    public $fillable = [
        'admin_email',
        'withdraw_fees',
        'withdraw_from_day',
        'withdraw_to_day',
        'topup_process_fees',
        'allow_first_withdraw',
        'minimum_withdraw_amount',
        'profit_sharing_commision_l1',
        'profit_sharing_commision_l2',
        'profit_sharing_commision_l3'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'admin_email' => 'string',
        'withdraw_fees' => 'integer',
        'withdraw_from_day' => 'integer',
        'withdraw_to_day' => 'integer',
        'allow_first_withdraw' => 'integer',
        'minimum_withdraw_amount' => 'integer',
        'profit_sharing_commision_l1' => 'integer',
        'profit_sharing_commision_l2' => 'integer',
        'profit_sharing_commision_l3' => 'integer'
    ];

}
