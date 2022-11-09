<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class OwnershipBonus
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property float profit
 * @property float amount
 */
class OwnershipBonus extends Model
{
    public $table = 'ownership';
    public $fillable = [
        'user_id',
        'profit',
        'amount',
        'commission',
        'percent',
        'file_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'profit' => 'float',
        'amount' => 'float'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
