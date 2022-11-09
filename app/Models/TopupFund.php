<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class TopupFund
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property string amount
 * @property string reciept_topup
 * @property string reciept_process
 * @property integer status
 */
class TopupFund extends Model
{
    public $table = 'topup_funds';

    public $fillable = [
        'user_id',
        'processing_fees',
        'amount',
        'remarks',
        'processing_percentage',
        'reciept_topup',
        'reciept_process',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'string',
        'reciept' => 'string',
        'processing_fees' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'amount' => 'required|numeric',
        'reciept_topup' => 'required',
        'reciept_process' => 'required'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
