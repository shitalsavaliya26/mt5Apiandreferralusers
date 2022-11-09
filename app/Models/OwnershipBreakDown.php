<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class OwnershipBreakDown
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property integer from_user_id
 * @property integer percentage
 * @property double commission
 * @property double amount
 */
class OwnershipBreakDown extends Model
{
    public $table = 'ownership_breakdown';
    public $fillable = [
        'user_id',
        'commission',
        'percentage',
        'from_user_id',
        'amount',
        'file_id'
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
