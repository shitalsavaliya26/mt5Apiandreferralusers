<?php

namespace App;

use App\Models\Rank;
use App\Models\UserBank;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles,SoftDeletes;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'user';

    /**
     * @property string $role
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sponsor',
        'full_name',
        'user_name',
        'email',
        'profile_picture',
        'identification_number',
        'address',
        'city',
        'state',
        'country_id',
        'role',
        'phone_number',
        'mt4_username',
        'rank_id',
        'status',
        'fixed_rank',
        'total_capital',
        'password',
        'mt4_password',
        'secure_password',
        'last_login_at',
        'password_otp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'secure_password',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'total_capital' => 'int',
        'identification_number' => 'string',
        'profile_picture' => 'string',
        'password_otp' => 'int',
    ];
    protected function castAttribute($key, $value)
    {
       if (! is_null($value)) {
           return parent::castAttribute($key, $value);
       }
       switch ($this->getCastType($key)) {
           case 'int':
           case 'integer':
           return (int) 0;
           case 'real':
           case 'float':
           case 'double':
           return (float) 0;
           case 'string':
           return '';
           case 'bool':
           case 'boolean':
           return false;
           case 'object':
           case 'array':
           case 'json':
           return [];
           case 'collection':
           return new BaseCollection();
           case 'date':
           return $this->asDate('0000-00-00');
           case 'datetime':
           return $this->asDateTime('0000-00-00');
           case 'timestamp':
           return $this->asTimestamp('0000-00-00');
           default:
           return $value;
       }
    }
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'full_name' => ['required', 'string'],
        'user_name' => ['required', 'unique:users'],
        'identification_number' => ['required', 'numeric','unique:users'],
        'address' => ['required'],
        'country_id' => ['required'],
        'phone_number' => ['required', 'digits:10'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'secure_password' => ['required', 'string', 'confirmed'],
        'password' => ['required', 'string', 'confirmed'],
        'name' => ['required', 'string'],
        'account_number' => ['required', 'numeric'],
        'account_holder' => ['required', 'string'],
        'swift_code' => ['required', 'string'],
        'branch' => ['required', 'string'],
        'bank_country_id' => ['required'],
        //'mt4_username' => ['required'],
        //'mt4_password' => ['required'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $editRules = [
        'full_name' => ['required', 'string'],
        'user_name' => ['required', 'unique:users'],
        'identification_number' => ['required', 'numeric','unique:users'],
        'address' => ['required'],
        'country_id' => ['required'],
        'phone_number' => ['required', 'digits:10'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'name' => ['required', 'string'],
        'account_number' => ['required', 'numeric'],
        'account_holder' => ['required', 'string'],
        'swift_code' => ['required', 'string'],
        'branch' => ['required', 'string'],
        'bank_country_id' => ['required'],
        //'mt4_username' => ['required'],
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $editMyProfileRules = [
        'full_name' => ['required', 'string'],
        'user_name' => ['required', 'unique:users'],
        'identification_number' => ['required', 'numeric','unique:users'],
        'address' => ['required'],
        'country_id' => ['required'],
        'phone_number' => ['required', 'digits:10'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'name' => ['required', 'string'],
        'account_number' => ['required', 'numeric'],
        'account_holder' => ['required', 'string'],
        'swift_code' => ['required', 'string'],
        'branch' => ['required', 'string'],
        'bank_country_id' => ['required'],
    ];

    private $role;

    public function country()
    {
        return $this->belongsTo(UserBank::class, 'country_id');
    }
    public function userBank()
    {
        return $this->hasOne(UserBank::class, 'user_id');
    }
    public function total_deposite()
    {
        return $this->hasMany(Models\TopupFund::class, 'user_id');
    }
    public function userwallet()
    {
        return $this->hasOne(Models\UserWallet::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === self::ADMIN_TYPE;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }
    public function sponsor_detail()
    {
        return $this->belongsTo(User::class, 'sponsor');
    }

    public function history() {
        return $this->hasMany('App\Models\TraderHistory', 'user_id', 'id');
    }

    public function trading_profits() {
        return $this->hasMany('App\Models\TradingProfit', 'user_id', 'id');
    }
}
