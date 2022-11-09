<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class StaffUser
 * @package App\Models
 * @version January 30, 2020, 9:42 am UTC
 *
 * @property string name
 */
class StaffUser extends Model
{
    use HasRoles;

    protected $guard_name = 'admin';

    public $table = 'admins';

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_name' => 'required',
        'password' => 'required_with:password_confirmation|same:password_confirmation',
        'email' => ['required', 'email', 'max:255', 'unique:admins'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $editRules = [
        'user_name' => 'required',
    ];
}
