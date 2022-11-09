<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLoginActivity;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        if(Auth::check()){
            // return redirect('avanya-vip-portal/dashboard');
        }
        return view('auth.admin.admin_login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'avanya-vip-portal/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
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
        AdminLoginActivity::create([
            'user_id' => $user->id,
            'login_at' => Carbon::now()->toDateTimeString(),
            'ip_address' => $request->getClientIp(),
        ]);

    }

    public function logout(Request $request){
        // die('test');
        Auth::guard('admin')->logout();
        return redirect()->route( 'admin_login' );
    }
}
