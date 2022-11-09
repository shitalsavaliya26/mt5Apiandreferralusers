<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserDemo
 * @package App\Models
 * @version December 27, 2019, 5:26 am UTC
 *
 * @property string name
 * @property string email
 */
class UserDemo extends Model
{
    public $table = 'user_demos';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required'
    ];


}
