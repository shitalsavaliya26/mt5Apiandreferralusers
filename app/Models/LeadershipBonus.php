<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class LeadershipBonus
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property float profit
 * @property float amount
 */
class LeadershipBonus extends Model
{
    public $table = 'leadership';
    public $fillable = [
        'user_id',
        'profit',
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
        'profit' => 'float',
        'amount' => 'float'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
