<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Country
 * @package App\Models
 * @version January 2, 2020, 9:52 am UTC
 *
 * @property string code
 * @property string name
 * @property integer phonecode
 */
class Country extends Model
{

    public $table = 'countries';

    public $fillable = [
        'code',
        'name',
        'phonecode'
    ];
}
