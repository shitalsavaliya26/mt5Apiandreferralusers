<?php

namespace App\Http\Controllers;

use App\Models\PaymentBank;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWallet;
use Response;
use Mail;
use Helper;

/**
 * Class WithdrawController
 * @package App\Http\Controllers
 */
class WithdrawController extends AppBaseController
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function create(Request $request)
    {
        $items = $request->items ?? 5;

        $searchedDate = '';
        $user = User::find(auth::user()->id);
        $paymentSetting = PaymentBank::first();
        $setting = Setting::get();

        $query = Withdraw::query();
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        $withdraws = $query->where('user_id', auth::user()->id)->orderBy('id','desc')->paginate($items)->appends($request->except('_token'));
    $wallet = Wallet::where('user_id',auth::user()->id)->first();
    $UserWallet = UserWallet::where('user_id',auth::user()->id)->first();
    
        return view('withdraws.withdraw', compact('user', 'paymentSetting', 'setting', 'withdraws', 'searchedDate','wallet','UserWallet'))
            ->withItems($items);
    }

    /**
     * Store a newly created TopupFund in storage.
     * POST /topupFunds
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     * @retur
     */
    public function store(Request $request)
    {        
        $checkStatus = withdraw::where('user_id', auth::user()->id)->where('status', 0)->count();

        if ($checkStatus) {
            return redirect()->back()->with('error', 'You have already pending request.');
        }

        $input = $request->all();
        $request->validate([
            'amount' => 'required|numeric',
            'security_password' => 'required'
        ]);

        $setting = Setting::first();
        if($setting->minimum_withdraw_amount > $input['amount']){
            return redirect()->back()->with('error', 'Please enter minimum withdraw amount is '.$setting->minimum_withdraw_amount.'.');
        }

        $checkAmount = UserWallet::where('user_id',auth::user()->id)->first();
        if (!isset($checkAmount) || $input['amount'] > $checkAmount->withdrawal) {
            return redirect()->back()->with('error', 'You have insufficient balance.');
        }	

        $input['user_id'] = auth::user()->id;
        $input['withdrawal_fees'] = $setting->withdraw_fees;

        Withdraw::create($input);

        //Send mail notification    
        $data['user_id'] = $input['user_id'];
        $data['subject'] = 'Withdraw request has been created';
        $data['content'] = 'Withdraw request has been created by {{USERNAME}}';

        Helper::sendAdminNotification($data);

        return redirect()->back()->with('message', 'Withdraw request has been sent.');
    }

}
