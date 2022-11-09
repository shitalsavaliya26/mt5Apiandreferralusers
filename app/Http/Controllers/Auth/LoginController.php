<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password')];
        }

        return ['user_name' => $request->get('email'), 'password' => $request->get('password')];
    }

    protected function authenticated(Request $request, $user)
    {
	if ($user->deleted_at != null) {
            Auth::logout();
            return redirect(route('login'))->withErrors(['common' => 'Your account has been deleted by admin.']);
        }

        if ($user->status != 'active') {
            Auth::logout();

            return redirect(route('login'))->withErrors(['common' => 'Your account has been deactivated by admin.']);
        }

        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
        ]);

        //Auth::logoutOtherDevices(request('password'));

        if ($user->email_verified_at == null) {
            Auth::logout();

            return redirect(route('login'))->withErrors(['common' => 'You need to verify your e-mail !']);
        }
    }
}
