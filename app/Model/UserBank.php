<?php

namespace  App\Model;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{

    protected $table = 'user_banks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'branch',
        'account_holder',
        'account_number',
        'swift_code',
        'bank_country_id',
    ];
    /*
    public function userBank()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    */

}
