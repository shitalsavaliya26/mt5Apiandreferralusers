<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class NetworkTree
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer refferal_id
 * @property integer parent_id
 * @property double total_sale
 * @property double total_group_sale
 * @property double monthly_group_sale
 */
class NetworkTree extends Model
{
    public $table = 'networks_tree';

    public $fillable = [
        'refferal_id',
        'parent_id',
        'total_sale',
        'total_group_sale',
        'monthly_group_sale'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'refferal_id' => 'integer',
        'parent_id' => 'integer',
        'total_sale' => 'double',
        'total_group_sale' => 'double',
        'monthly_group_sale' => 'double',
    ];

    public function refferalName()
    {
        return $this->belongsTo(User::class, 'refferal_id');
    }
}
