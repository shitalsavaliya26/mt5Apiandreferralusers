<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\App;

/**
 * Class FAQ
 * @package App\Models
 * @version December 31, 2019, 10:30 am UTC
 *
 * @property string question
 * @property string answer
 * @property string language
 * @property integer status
 */
class FAQ extends Model
{
    public $table = 'faqs';

    public $fillable = [
        'question',
        'answer',
        'language',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'question' => 'string',
        'answer' => 'string',
        'language' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question' => 'required',
        'answer' => 'required',
        'language' => 'required',
    ];

}
