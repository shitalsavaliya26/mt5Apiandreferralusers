<?php

namespace App\Models;

use Eloquent as Model;


class ImportHistory extends Model
{
    public $table = 'import_history';

    public $fillable = [
        'file_name',
    ];
}
