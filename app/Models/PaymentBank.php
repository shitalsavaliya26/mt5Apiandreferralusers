<?php

namespace App\Models;

use Eloquent as Model;

class PaymentBank extends Model
{
    public $table = 'payments_bank';

    public $fillable = [
        'account_name',
        'bank_name',
        'account_number',
        'account_opening',
        'second_account_name',
        'second_bank_name',
        'second_account_number',
        'second_account_opening',
        'rmb',
        'ntd',
        'hkd',
        'usdt',
        'jpy',
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $updateRules = [
        'account_name' => 'required',
        'bank_name' => 'required',
        'account_number' => 'required|numeric',
        'account_opening' => 'required',
        'second_account_name' => 'required',
        'second_bank_name' => 'required',
        'second_account_number' => 'required|numeric',
        'second_account_opening' => 'required',
        'rmb' => 'required|numeric',
        'ntd' => 'required|numeric',
        'hkd' => 'required|numeric',
        'usdt' => 'required|numeric',
        'jpy' => 'required|numeric'
    ];

}
