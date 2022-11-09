<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ImportHistory extends Model
{
    public $table = 'import_history';

    public $fillable = [
        'file_name',
    ];

}
