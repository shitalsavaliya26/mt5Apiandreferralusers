<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreateTopupFundAPIRequest;
use App\Models\PaymentBank;
use App\Models\Setting;
use App\Models\TopupFund;
use App\Models\Trader;
use App\Models\TraderHistory;
use App\Models\UserBank;
use App\Repositories\TopupFundRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\UserWallet;
use App\Models\Wallet;
use Mail;
use Helper;

/**
 * Class TopupFundController
 * @package App\Http\Controllers
 */
class TopupFundController extends AppBaseController
{
    /** @var  TopupFundRepository */
    private $topupFundRepository;

    public function __construct(TopupFundRepository $topupFundRepo)
    {
        $this->middleware(['auth', 'verified']);
        $this->topupFundRepository = $topupFundRepo;
    }

    /**
     * Display a listing of the TopupFund.
     * GET|HEAD /topupFunds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $topupFunds = TopupFund::where('user_id', auth::user()->id);
    }

    public function getTopupFunds(Request $request)
    {
        $items = $request->items ?? 5;

        $user = User::find(auth::user()->id);
        $userBank = UserBank::where('user_id', auth::user()->id)->first();
        $setting = Setting::first();
        $paymentSetting = PaymentBank::first();
        $query = TopupFund::where('user_id', auth::user()->id);

        $searchedDate = '';
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        $topupFunds = $query->orderby('id','desc')->paginate($items)->appends($request->except('_token'));
	$wallet = Wallet::where('user_id',auth::user()->id)->first();

    $UserWallet = UserWallet::where('user_id',auth::user()->id)->first();

        return view('topup_funds.topup',
            compact(
                'user',
                'userBank',
                'setting',
                'topupFunds',
                'paymentSetting',
                'searchedDate',
        'wallet',
        'UserWallet'
            )
        )->withItems($items);
    }

    /**
     * Store a newly created TopupFund in storage.
     * POST /topupFunds
     *
     * @param CreateTopupFundAPIRequest $request
     *
     * @retur
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function store(CreateTopupFundAPIRequest $request)
    {
        // dd($request->all());
        $checkStatus = TopupFund::where('user_id', auth::user()->id)->where('status', 0)->count();

        if ($checkStatus) {
            return redirect()->back()->with('error', 'You have already pending request.');
        }

    // $checkAmount = Wallet::where('user_id', auth::user()->id)->first();
    $checkAmount = UserWallet::where('user_id',auth::user()->id)->first();    

        // if (!empty($checkAmount) && ($request->amount > $checkAmount->topup_fund)) {
        //     return redirect()->back()->with('error', 'You have insufficient balance.');
        // }
        $setting = Setting::first();
        $input = $request->all();   
        $input['processing_percentage'] = ($request->processing != '') ? $request->processing : 0;
        $input['user_id'] = auth::user()->id;
        $topupFund = $this->topupFundRepository->create($input);

        //Send mail notification    
        $data['user_id'] = $input['user_id'];
        $data['subject'] = 'Deposit request has been received';
        $data['content'] = 'Deposit request has been sent by {{USERNAME}}';

        Helper::sendAdminNotification($data);

        return redirect()->back()->with('message', 'Topup request has been sent.');

    }

    public function dropzoneRecieptTopup(Request $request)
    {
        $file = $request->file('receipt_topup');
        $filename=time() .'_receipt_topup.'. $file->getClientOriginalExtension();   
        $file->storeAs('topup_reciepts', $filename);

        return response()->json(['target_file' => $filename]);
    }

    public function dropzoneRecieptProcess(Request $request)
    {
        $file = $request->file('receipt_process');
        $filename=time() .'_receipt_process.'. $file->getClientOriginalExtension();   
        $file->storeAs('process_reciepts', $filename);

        return response()->json(['target_file' => $filename]);
    }

    /**
     * return view get_traders
     */
    public function chooseTraders(Request $request)
    {
        // dd($request);
        $items = $request->items ?? 8;

        /** @var Trader $traders */
        
        $traders = Trader::where('status',0)->orderBy('orders','asc')->paginate($items, ['*'], 'traders')->appends($request->except('_token'));
        $query = TraderHistory::with('traders');

        $searchedDate = '';
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        if (!empty($request->user_name)) {
            $userName = $request->user_name;
            
            $traders = Trader::where('status',0)->where('name', 'like', "%{$userName}%")->orderBy('orders','asc')->paginate(8)->appends($request->except('_token'));

            if($traders->isEmpty()){
                return redirect()->back()->with('message','No records found , Try different.');
            }
        }

        $traderHistories = $query->where('user_id', auth::user()->id)->orderBy('created_at','desc')
            ->paginate($items, ['*'], 'traderHistories')->appends($request->except('_token'));       


        $traderHistoriesIds = array_pluck($traderHistories->whereIn('status',[0,1]), 'trader_id');
        $amount = TraderHistory::where('user_id', auth::user()->id)->whereIn('status',[0,1])->pluck('amount','trader_id')->toArray();
        // dd($amount);
        return view('traders.traders_view', compact('traders', 'traderHistories', 'traderHistoriesIds', 'searchedDate','amount'))
            ->withItems($items);
    }

    /**
     * return view
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTraders(Request $request)
    {
        // print_r($request->all());die();
        $traderHistoryCount = TraderHistory::where('user_id', auth::user()->id)->count();

        $traderHistory = TraderHistory::where('user_id', auth::user()->id)->where('status',0)->delete();
        $ids = array();
        $requestId = $request->var_id;
        $updated = 0;

        if(!empty($requestId)){
            foreach ($requestId as $re) {
                $ids[] = $re;
            }
            // if($activetradersHistory == count($requestId)){
            //     return response()->json([
            //         'success' => false,
            //     ]);
            // }
            $data = array();
            TraderHistory::where(['user_id'=> auth::user()->id,'status'=>1])->whereNotIn('trader_id',$ids)->whereIn('trader_id',$request->trader_id)->update(['status'=>3]);

            foreach ($ids as $id) {
                $activetradersHistory = TraderHistory::where('user_id', auth::user()->id)->where('trader_id',$id)->where('status',1)->get();

                if ($activetradersHistory->count() == 0 || $activetradersHistory[0]->amount != $request->amount[$id]) {
                    $updated = 1;
                    $data[] = [
                        'trader_id' => $id,
                        'amount' => isset($request->amount[$id])?$request->amount[$id]:"0",
                        'user_id' => Auth::id(),
                        'status' => (($traderHistoryCount > 0) ? 0 : 1),
                        'created_at' => Carbon::now()
                    ];

                }
            } 
            TraderHistory::insert($data);
        }else{
            $approved = TraderHistory::where(['user_id'=> auth::user()->id,'status'=>1])->whereIn('trader_id',$request->trader_id)->get();
            if($approved->count() > 0 || $traderHistory){
                TraderHistory::where(['user_id'=> auth::user()->id,'status'=>1])->whereIn('trader_id',$request->trader_id)->update(['status'=>3]);
                return response()->json([
                    'success' => true,
                ]);
            }
            return response()->json([
                    'success' => false,
                ]);
        }
 
        return response()->json([
            'success' => ($updated) ? true :false,
        ]);
    }
}
