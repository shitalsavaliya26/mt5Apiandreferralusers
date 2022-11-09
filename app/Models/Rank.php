<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rank
 * @package App\Models
 * @version December 31, 2019, 6:57 am UTC
 *
 * @property string name
 * @property integer direct_sale
 * @property integer downline_sales
 * @property integer downline
 * @property integer direct_downline
 * @property integer total_downline
 * @property integer ownership_bonus
 * @property integer unilevel
 * @property integer leader_bonus
 * @property integer trading_profit
 * @property integer profit_sharing
 */
class Rank extends Model
{
    use SoftDeletes;

    public $table = 'ranks';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'direct_sale',
        'downline_sales',
        'downline',
        'direct_downline',
        'total_downline',
        'ownership_bonus',
        'unilevel',
        'leader_bonus',
        'trading_profit',
        'profit_sharing'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'direct_sale' => 'integer',
        'downline_sales' => 'integer',
        'downline' => 'integer',
        'direct_downline' => 'integer',
        'total_downline' => 'integer',
        'ownership_bonus' => 'integer',
        'unilevel' => 'integer',
        'leader_bonus' => 'integer',
        'trading_profit' => 'integer',
        'profit_sharing' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'direct_sale' => 'required|numeric|digits_between:1,5',
        'downline' => 'required|numeric|digits_between:1,5',
        'direct_downline' => 'required|numeric|digits_between:1,5',
        'total_downline' => 'required|numeric|digits_between:1,5',
        'ownership_bonus' => 'required|numeric|digits_between:1,5',
        'unilevel' => 'required|numeric|digits_between:1,5',
        'leader_bonus' => 'required|numeric|digits_between:1,5',
        'trading_profit' => 'required|numeric|digits_between:1,5',
    ];

}
