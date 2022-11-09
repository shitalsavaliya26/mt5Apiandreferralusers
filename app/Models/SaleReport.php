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
 * @property double amount
 */
class SaleReport extends Model
{
    public $table = 'sale_report';

    public $fillable = [
        'user_id',
        'sale'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'sale' => 'double'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
