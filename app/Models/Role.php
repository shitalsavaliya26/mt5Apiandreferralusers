<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role
 * @package App\Models
 * @version January 30, 2020, 9:42 am UTC
 *
 * @property string name
 */
class Role extends SpatieRole
{
    protected $guard_name = 'admin';

    public $table = 'roles';

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
        'name' => 'required'
    ];
}
