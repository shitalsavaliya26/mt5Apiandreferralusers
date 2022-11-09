<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Package
 * @package App\Models
 * @version December 30, 2019, 12:50 pm UTC
 *
 * @property string name
 * @property integer amount
 * @property string status
 */
class Package extends Model
{
    public $table = 'packages';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'amount' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/ '
    ];
}
