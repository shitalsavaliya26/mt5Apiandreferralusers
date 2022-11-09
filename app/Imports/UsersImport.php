<?php

namespace App\Imports;

use App\Notifications\EmailVerificationNotification as EmailVerificationNotification;
use App\Models\Country;
use App\Models\NetworkTree;
use App\Models\Rank;
use App\Models\UserBank;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeImport;
use Session;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     *
     */

    public static function beforeImport(BeforeImport $event)
    {
        $worksheet = $event->reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        if ($highestRow < 2) {
            $error = \Illuminate\Validation\ValidationException::withMessages([]);
            $failure = new Failure(1, 'rows', [0 => 'Now enough rows!']);
            $failures = [0 => $failure];
            throw new ValidationException($error, $failures);
        }
    }
    public function model(array $row)
    {
        // return $row;

        $array = '';
        $user_array = '';
        $checkUser = [];
        $validator = Validator::make($row, [
            // 'sponsor' =>'required',
            'identification_number' => 'required',
            'email' => 'required|email',
            'user_name' => 'required',
            'full_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'secure_password' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'country' => 'required'
        ]);
        $userFullName = isset($row['full_name']) ? $row['full_name'] : '';
        $userName = isset($row['user_name']) ? $row['user_name'] : '';

        if (isset($row['sponsor'])) {
            $checkUser = User::where('user_name', $row['sponsor'])->first();
        }   

        if(isset($row['rank']) && $row['rank']!=""){
            $rank = Rank::where('name',$row['rank'])->first();

        }else {
            $rank = Rank::orderBy('id','asc')->first();
        }
        $rankId = isset($rank) ? $rank->id : "1";
       // dd($rankId);

        if (isset($row['country'])) {
            $country = Country::where('name', ucfirst($row['country']))->first();
        }
        $countryId = isset($country) ? $country->id : '';

        if (isset($row['bank_country'])) {
            $bankCountry = Country::where('name', ucfirst($row['bank_country']))->first();
        }
        $bankCountryId = isset($bankCountry) ? $bankCountry->id : $countryId ;
        
        if ($validator->fails()) {
            if (!empty($userFullName)) {
                $array .= $userFullName . ' ';
            } else {
                $array .= $userName . ' ';
            }
            Session::push('errors_message', $array);
        } else {
            // dd($row);
            if (1) {

        		$user = User::where('email', $row['email'])->Where('identification_number', $row['identification_number'])->Where('user_name', $row['user_name'])->withTrashed()->first();
                // dd($user);
                if(empty($user)) {
                    try {
    		            $user = User::create([
                            'sponsor' => $checkUser!=null?$checkUser->id:0,
                            'full_name' => $row['full_name'],
                            'user_name' => $row['user_name'],
                            'identification_number' => $row['identification_number'],
                            'address' => $row['address'],
                            'city' => $row['city'],
                            'state' => $row['state'],
                            'country_id' => $countryId,
                            'phone_number' => $row['phone_number'],
                            'role' => 'user',
                            'rank_id' => $rankId,
                            'email' => $row['email'],
                            // 'mt4_username' => isset($row['mt4_username']) ? $row['mt4_username'] : '',
                            'password' => Hash::make($row['password']),
                            'secure_password' => Hash::make($row['secure_password']),
                            // 'mt4_password' => isset($row['mt4_password']) ? Hash::make($row['mt4_password']) : '',
                        ]);
                        UserBank::create(['user_id' => $user->id,
                            'name' => isset($row['name']) ? $row['name'] : '',
                            'branch' => isset($row['branch']) ? $row['branch'] : '',
                            'account_holder' => isset($row['account_holder']) ? $row['account_holder'] : '',
                            'account_number' => isset($row['account_number']) ? $row['account_number'] : '',
                            'swift_code' => isset($row['swift_code']) ? $row['swift_code'] : '',
                            'bank_country_id' => $bankCountryId,
                        ]);
                        if($checkUser!=null){
                            NetworkTree::create([
                                'refferal_id' => $user->id,
                                'parent_id' => $checkUser->id
                            ]);
                        }
                        UserWallet::create([
                            'user_id' => $user->id,
                        ]);
                        $insert = Session::has('insert') ? Session::get('insert') : 0;
                        $insert++;
                        /*Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
                            $message->from('avanya@conatact.com', 'Avanya MLM');
                            $message->subject("Welcome to Avanya!");
                            $message->to($user->email);
                        });*/
                        
                        // event(new Registered($user));
                        Session::put('insert', $insert);
                        $user->notify(new EmailVerificationNotification($user));
                        return ;
                    }catch(\Illuminate\Database\QueryException $e){
                        // dd($e->getMessage());
                        if(strstr($e->getMessage(), 'users_email_unique')){
                            $user_array .= $row['email'];
                            Session::push('email_error_message', $user_array);
                            return;
                        }
                        if(strstr($e->getMessage(), 'users_identification_number_unique')){
                            $user_array .= $row['identification_number'];
                            Session::push('duplicate_errors_message', $user_array);
                            return;
                        }
                    } catch (Exception $e) {
                        // dd($e->getMessage());
                        return;
                    }

                } else {
                    $array = [
                        'sponsor' => $checkUser!=null?$checkUser->id:0,
                        'full_name' => $row['full_name'],
                        'user_name' => $row['user_name'],
                        'identification_number' => $row['identification_number'],
                        'address' => $row['address'],
                        'city' => $row['city'],
                        'state' => $row['state'],
                        'country_id' => $countryId,
                        'phone_number' => $row['phone_number'],
                        'role' => 'user',
                        'rank_id' => $rankId,
                        'email' => $row['email'],
                        // 'mt4_username' => isset($row['mt4_username']) ? $row['mt4_username'] : '',
                        'password' => Hash::make($row['password']),
                        'secure_password' => Hash::make($row['secure_password']),
                        // 'mt4_password' => isset($row['mt4_password']) ? Hash::make($row['mt4_password']) : ''
                    ];
                    // $insert = Session::has('insert') ? Session::get('insert') : 0;
                    // $insert++;
                    // event(new Registered($user));
                    // Session::put('insert', $insert);
                    // $user->update($array);
                    // if($checkUser!=null){
                    //     $network_tree = NetworkTree::where([
                    //             'refferal_id' => $user->id,
                    //             'parent_id' => $checkUser->id
                    //         ])->count();
                    //     if($network_tree <= 0){
                    //         NetworkTree::where(['refferal_id' => $user->id])->delete();
                    //         NetworkTree::create([
                    //             'refferal_id' => $user->id,
                    //             'parent_id' => $checkUser->id
                    //         ]);
                    //     }
                    // }
                    // if (!empty($userFullName)) {
                    //     $user_array .= $userFullName . ' ';
                    // } else {
                    //     $user_array .= $userName . ' ';
                    // }
                    // Session::push('exist_errors_message', $user_array);
                }
            } else {
                if (!empty($userFullName)) {
                    $array .= $userFullName . ' ';
                } else {
                    $array .= $userName . ' ';
                }
                Session::push('errors_message', $array);
            }
        }
    }
}
