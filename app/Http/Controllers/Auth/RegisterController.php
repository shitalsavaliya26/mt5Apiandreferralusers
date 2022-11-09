<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserBank;
use App\Models\Wallet;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => ['required', 'string'],
            'user_name' => ['required', 'unique:users'],
            'identification_number' => ['required', 'numeric'],
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
            'mt4_username' => ['required'],
            'mt4_password' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'sponsor' => $data['sponser_name'],
            'full_name' => $data['full_name'],
            'user_name' => $data['user_name'],
            'identification_number' => $data['identification_number'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country_id' => $data['country_id'],
            'phone_number' => $data['phone_number'],
            'role' => 'user',
            'email' => $data['email'],
            'mt4_username' => $data['mt4_username'],
            'password' => Hash::make($data['password']),
            'secure_password' => Hash::make($data['secure_password']),
            'mt4_password' => Hash::make($data['mt4_password']),
        ]);

        $userBank = new UserBank([
            'name' => $data['name'],
            'branch' => $data['branch'],
            'account_holder' => $data['account_holder'],
            'account_number' => $data['account_number'],
            'swift_code' => $data['swift_code'],
            'bank_country_id' => $data['bank_country_id'],
        ]);

        $user->userBank()->save($userBank);
        
        $UserWallet = UserWallet::create([
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
