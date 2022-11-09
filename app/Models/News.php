<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\App;

/**
 * Class News
 * @package App\Models
 * @version December 31, 2019, 10:30 am UTC
 *
 * @property string title
 * @property string language
 * @property string details
 * @property string image
 * @property integer status
 */
class News extends Model
{
    public $table = 'news';

    public $fillable = [
        'title',
        'language',
        'details',
        'image',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'language' => 'string',
        'image' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'language' => 'required',
        'image' => 'mimes:jpeg,jpg,png,gif|required'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $updateRules = [
        'title' => 'required',
        'language' => 'required',
    ];

    public function TextTrans($text)
    {
        $locale = App::getLocale();
        $column = $text . '_' . $locale;

        return $this->{$column};
    }
}
