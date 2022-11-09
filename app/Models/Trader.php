<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\TradersTranslation;

/**
 * Class Trader
 * @package App\Models
 * @version December 31, 2019, 10:30 am UTC
 *
 * @property string name
 * @property string profile_picture
 * @property string graph_picture
 * @property string description
 * @property integer status
 */
class Trader extends Model
{
    public $table = 'traders';

    public $fillable = [
        'name',
        'profile_picture',
        'graph_picture',
        'description',
        'minimum_amount',
        'maximum_amount',
        'mt5_username',
        'mt5_password',
        'subtitle',
        'best_trader_image',
        'status',
        'orders'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'profile_picture' => 'string',
        'graph_picture' => 'string',
        'best_trader_image' => 'string',
        'description' => 'string',
        'minimum_amount' => 'string',
        'maximum_amount' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'profile_picture' => 'mimes:jpeg,jpg,png,gif',
        'graph_picture' => 'mimes:jpeg,jpg,png,gif',
        'best_trader_image' => 'mimes:jpeg,jpg,png,gif'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required',
        'profile_picture' => 'mimes:jpeg,jpg,png,gif',
        'graph_picture' => 'mimes:jpeg,jpg,png,gif',
        'best_trader_image' => 'mimes:jpeg,jpg,png,gif'
    ];

    public function translation() {
        return $this->hasOne('App\Models\TradersTranslation', 'trader_id', 'id')->where('language',\App::getLocale());
    }

    public function history() {
        return $this->hasOne('App\Models\TraderHistory', 'trader_id', 'id');
    }
}
