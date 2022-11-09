<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class TotalReport
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property double trading_profit
 * @property double unilevel
 * @property double profit_sharing
 * @property double leadership_bonus
 * @property double ownership_bonus
 * @property double total
 *
 */
class TotalReport extends Model
{
    public $table = 'total_reports';
    public $fillable = [
        'user_id',
        'trading_profit',
        'unilevel',
        'profit_sharing',
        'leadership_bonus',
        'ownership_bonus',
        'total',
        'profit_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
