<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\UpdateMyProfileAPIRequest;
use App\Models\Country;
use App\Models\TradingProfit;
use App\Models\UserBank;
use App\Repositories\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware(['auth', 'verified'], ['except' => ['checkSponsorUser']]);
        $this->userRepository = $userRepo;
    }

    /**
     * Show the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSponsorUser(Request $request)
    {
        if (!empty($request)) {
            $sponsorUserName = $request->input('user_name');
            $user = User::where('user_name', $sponsorUserName)->first();
            if ($user) {
                return response()->json([
                    'message' => 'User Name Exist!',
                    'user_id' => $user->id,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => 'User Name Not Exist!',
                    'status' => 'error',
                ]);
            }
        }
    }
    /**
     * Show the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSponsorUserExit(Request $request)
    {
        if (!empty($request)) {
            $sponsorUserName = $request->input('user_name');
            $user = User::where('user_name', $sponsorUserName)->first();
            if ($user) {
                if ($user->id == $request->id) {
                    return response()->json([
                        'message' => 'Do not allow to use same user as sponsor name',
                        'status' => 'error'
                    ]);    
                }
                return response()->json([
                    'message' => 'User Name Exist!',
                    'user_id' => $user->id,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => 'User Name Not Exist!',
                    'status' => 'error',
                ]);
            }
        }
    }

    /**
     * Show the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSecurityPassword(Request $request)
    {
        if (!empty($request)) {
            $securityPassword = $request->input('security_password');
            if (!Hash::check($securityPassword, auth::user()->secure_password)) {
                return response()->json([
                    'message' => 'InValid',
                    'status' => 'error'
                ]);
            }
            return response()->json([
                'message' => 'Valid',
                'status' => 'success'
            ]);

        }
    }

    /**
     * return view my profile
     */
    public function myProfile()
    {
        $user = User::with('rank')->find(auth::user()->id);
        $userBank = UserBank::where('user_id', auth::user()->id)->first();
        $countries = Country::get();

        if (empty($user)) {
            redirect()->back()->with('error', 'no user found');
        }

        return view('users.my_profile', compact('user', 'userBank', 'countries'));
    }


    /**
     * Update the specified in storage.
     * PUT/PATCH /user/{id}
     *
     * @param int $id
     * @param UpdateMyProfileAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateMyProfile($id, UpdateMyProfileAPIRequest $request)
    {
        $input = $request->all();

        if ($request->has('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time().'-'.$image->getClientOriginalName();
            $image->storeAs('userProfile', $imageName);
            $input['profile_picture'] = $imageName;
        }

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (isset($input['password'])) {

            $request->validate([
                'password' => 'confirmed',
            ]);

            $input['password'] = Hash::make($request->password);
        } else {
            $input['password'] = $user->password;
        }

        if (isset($input['secure_password'])) {

            $request->validate([
                'secure_password' => 'confirmed',
            ]);

            $input['secure_password'] = Hash::make($request->secure_password);
        } else {
            $input['secure_password'] = $user->secure_password;
        }

        $this->userRepository->update($input, $id);

        $userBank = UserBank::where('user_id', $id)->first();

        $userBank->update([
            'name' => $input['name'],
            'branch' => $input['branch'],
            'account_holder' => $input['account_holder'],
            'account_number' => $input['account_number'],
            'swift_code' => $input['swift_code'],
            'bank_country_id' => $input['bank_country_id'],
        ]);

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }

    public function deleteProfileImage(Request $request)
    {
        User::where('id',auth::user()->id)->update(['profile_picture'=>null]);
        return redirect()->back()->with('delete-image', 'Profile deleted successfully.');
    }
    
    /**
     * return view my profile
     */
    public function funding()
    {
        /** @var User $user */
        $user = $this->userRepository->find(auth::user()->id);
        return view('users.funding', compact('user'));
    }

    /**
     * return view my profile
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tradingProfit(Request $request)
    {
        $items = $request->items ?? 5;

        $totalCapital = User::find(auth::user()->id)->total_capital;

        $searchedDate = '';
        $query = TradingProfit::query();
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }
        $tradingProfits = $query->where('user_id', auth::user()->id)->orderBy('id','desc')->paginate($items)->appends($request->except('_token'));
        
        $totalTradingProfit = TradingProfit::where('user_id',auth::user()->id)->sum('profit');
        
        return view('users.trading_profit', compact('tradingProfits', 'totalCapital', 'searchedDate','totalTradingProfit'))->withItems($items);
    }
}
