<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\sendUserNotification as sendUserNotification;
use App\Exports\TopupExport;
use App\Http\Controllers\AppBaseController;
use App\Imports\TopupImport;
use App\Models\TopupFund;
use App\Models\Wallet;
use App\Repositories\TopupFundRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use App\Models\UserWallet;
use App\User;
use Illuminate\Support\Facades\Mail;
use Helper;

/**
 * Class TopupFundController
 * @package App\Http\Controllers\Admin
 */
class TopupFundController extends AppBaseController
{
    /** @var  TopupFundRepository */
    private $topupFundRepository;

    public function __construct(TopupFundRepository $topupFundRepo)
    {
        $this->middleware('auth:admin');
        $this->topupFundRepository = $topupFundRepo;
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTopupFundsRequest(Request $request)
    {
        $data = $request->all();
        $query = TopupFund::has('users');
        $searchedDate = '';
        $name = '';

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereRaw("Date(created_at) >= '".date('Y-m-d',strtotime($request->start_date))."' and  Date(created_at) <= '".date('Y-m-d',strtotime($request->end_date))."' ");  // whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        if (!empty($request->username)) {
            $userName = $request->username;
            $query = $query->whereHas('users', function ($q) use ($userName) {
                $q->where('user_name', 'like', "%{$userName}%");
            });
            $name = $userName;
        }
        $topupFunds = $query->orderby('id','desc')->paginate(8)->appends($request->except('_token'));

        if ($request->ajax()) {
            return view('admin.topup.table', compact(  'topupFunds', 'searchedDate','name','data'));
        }
        // $mt5Obj = new \App\Http\Controllers\MT5Controller;
        // $depositData = [
        //         'servername' => 'mt5api.icdx.co.id:443',
        //         "auth_login"=>10032,//$user->mt4_username,
        //         "auth_password"=>'QNWBKD#2020',//$user->mt4_password,
        //         "from"=>\Carbon\Carbon::now()->format('Y-m-d'),
        //         "to"=>\Carbon\Carbon::now()->subDays(7)->format('Y-m-d'),
                
        // ];
        // // dd($depositData);
        // $history = $mt5Obj->HistoryGetTotal((object)$depositData); 
        // dd($history);

        return view('admin.topup.topup_request', compact('topupFunds', 'searchedDate','name','data'));
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateTopupRequest($id)
    {
        $topupFunds = $this->topupFundRepository->find($id);

        return view('admin.topup.update_request', compact('topupFunds'));
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateTopupStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'remarks' => 'required'
        ]);

        $input = $request->all();

        $topupFunds = $this->topupFundRepository->find($id);

        if (empty($topupFunds)) {
            return $this->sendError('not found');
        }
        $this->topupFundRepository->update($input, $id);

        //Send mail notification
        if($input['status'] == 1){
            $content = 'Deposit request has been Approved, MT5 account has amount deposited';
        }else{
            $content = 'Deposit request has been Rejected';
        }
        $user = User::where('id',$input['user_id'])->first();
        $user->mail_content = $content;            
        $user->notify(new sendUserNotification($user));
            

        if ($input['status'] == 1) {
            

            $userWallet_check = UserWallet::where('user_id', $input['user_id'])->first(); 
            if($userWallet_check == null){
                $UserWallet = UserWallet::create([
                    'user_id' => $input['user_id'],
                ]);
            }
            UserWallet::where('user_id', $input['user_id'])->increment('topup_fund', ($topupFunds->amount));
            $user = User::where('id',$input['user_id'])->first();

           
            /*********MT5 USER CREATE CODE**************/
            if (empty($user->mt4_username)) {                
                try{
                    $login = rand();
                    $inv_password = "Avnya2020M";//env('MASTER_PWD');
                    $password =  str_random(8);//env('MASTER_PWD');

                    $mt5Data = [
                        'Login' => $login,
                        'Name' => $user->user_name,
                        'Email' => $user->email,
                        'Group' => 'demo\OTM Kapital Berjangka\fee otm',
                        'MainPassword' => $inv_password,
                        'servername' => 'mt5demo.icdx.co.id:443',
                        'auth_login' => 10032,
                        'auth_password' => 'QNWBKD#2020',
                        'Leverage' => 100,
                        'Phone' => $user->phone_number,
                        'Address' => $user->address,
                        'City' => $user->city,
                        'State' => $user->state,
                        'Country' => 'Malasiya',
                        'ZipCode' => 111470,
                        'InvestPassword' => str_random(8),
                        'PhonePassword' => str_random(8)
                    ];
                    $mt5Obj = new \App\Http\Controllers\MT5Controller;
                    $responseCode = $mt5Obj->createAccount((object)$mt5Data);

                    if ($responseCode == 0) {

                        User::where('id',$input['user_id'])->update(['mt4_username'=> $login, 'mt4_password'=>$password]);
                        \Mail::send('emails.mt5_welcome', ['user' => $user,'login' => $login, 'password' => $password], function ($message) use ($user,$login,$password) {
                            // $message->from('avanya@conatact.com', 'MT5Trader');
                            $message->subject("Welcome to MT5Trader!");
                            $message->to($user->email);
                        });

                        // return response()->json(['success' => true, 'result' => 'Account Created Successfully'],200);
                    }else if ($responseCode == 3004) {
                        // return response()->json(['success' => false, 'result' => 'Account already exist'],200);
                    } else {
                        // return response()->json(['success' => false, 'result' => 'Something went wrong'],200);
                    }
                    
                }catch(\Exception $e){}
            }

            $user = User::where('id',$input['user_id'])->first();
            $mt5Obj = new \App\Http\Controllers\MT5Controller;
            $depositData = [
                    'servername' => 'mt5demo.icdx.co.id:443',
                    'auth_login' => 10032,
                    'auth_password' => 'QNWBKD#2020',
                    "login"=>(int)$user->mt4_username,
                    "type"=>2,
                    // "type"=>3,
                    "amount"=>round(($topupFunds->amount),2),
                    
            ];
            // dd($depositData);
            $mt5Obj->depositeAmount($depositData); 
            // Wallet::where('user_id', $input['user_id'])->decrement('total_balance', $input['amount']);
        }
        // dd("12345678");
        

        return redirect('avanya-vip-portal/get-topup-request')->with('message', 'status successfully updated');
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBulkTopupStatus(Request $request)
    {
        $ids = $request->ids;
        $status = $request->status;
        $remarks = $request->remarks;

        DB::table("topup_funds")->whereIn('id', explode(",", $ids))->update(['status' => $status, 'remarks' => $remarks]);        
        $data = DB::table("topup_funds")->whereIn('id', explode(",", $ids))->select('user_id','amount')->get();

        if ($request->status == 1) {

            foreach ($data as $key => $value) {
                $userWallet_check = UserWallet::where('user_id', $value->user_id)->first(); 
                if($userWallet_check == null){
                    $UserWallet = UserWallet::create([
                        'user_id' =>$value->user_id,
                    ]);
                }
                UserWallet::where('user_id', $value->user_id)->increment('topup_fund', $value->amount);

                $IDs = explode(",", $request->userIds);
                foreach ($IDs as $id) {
                    $user = User::where('id',$id)->first();
                    if (empty($user->mt4_username)) {                
                        try{
                            $login = rand();
                            $password = "Avnya2020M";//env('MASTER_PWD');

                            $mt5Data = [
                                'Login' => $login,
                                'Name' => $user->full_name,
                                'Email' => $user->email,
                                'Group' => 'demo\OTM Kapital Berjangka\fee otm',
                                'MainPassword' => $password,
                                'servername' => 'mt5api.icdx.co.id:443',
                                'auth_login' => 10032,
                                'auth_password' => 'QNWBKD#2020',
                                'Leverage' => 100,
                                'Phone' => $user->phone_number,
                                'Address' => $user->address,
                                'City' => $user->city,
                                'State' => $user->state,
                                'Country' => 'malasiya',
                                'ZipCode' => 111470,
                                'InvestPassword' => str_random(10),
                                'PhonePassword' => str_random(10)
                            ];
                            $mt5Obj = new \App\Http\Controllers\MT5Controller;
                            $responseCode = $mt5Obj->createAccount((object)$mt5Data);

                            if ($responseCode == 0) {
                                User::where('id',$id)->update(['mt4_username'=> $login, 'mt4_password'=>$password]);

                                    Mail::send('emails.mt5_welcome', ['user' => $user,'login' => $login, 'password' => $password], function ($message) use ($user,$login,$password) {
                                        $message->from('avanya@conatact.com', 'MT5Trader');
                                        $message->subject("Welcome to MT5Trader!");
                                        $message->to($user->email);
                                    });

                                // return response()->json(['success' => true, 'result' => 'Account Created Successfully'],200);
                            }else if ($responseCode == 3004) {
                                // return response()->json(['success' => false, 'result' => 'Account already exist'],200);
                            } else {
                                // return response()->json(['success' => false, 'result' => 'Something went wrong'],200);
                            }
                        }catch(\Exception $e){}
                    }
                    $user = User::where('id',$id)->first();
                    $mt5Obj = new \App\Http\Controllers\MT5Controller;
                    $depositData = [
                        'servername' => 'mt5api.icdx.co.id:443',
                        "auth_login"=>10032,//$user->mt4_username,
                        "auth_password"=>'QNWBKD#2020',//$user->mt4_password,
                        "login"=>(int)$user->mt4_username,
                        "type"=>2,
                        "amount"=>round(($value->amount - $value->processing_fees),2),
                    ];
                    $mt5Obj->depositeAmount((object)$depositData); 
                }
                // Wallet::where('user_id', $value->user_id)->decrement('total_balance', $value->amount);
                
                /*$user = User::find($value->user_id);
                if ($user->total_capital == null) {
                    $user->update(['total_capital'=>$value->amount]);
                } else {
                    $user->increment('total_capital',$value->amount);
                }*/
            }
        }

        return response()->json(['status' => true, 'message' => 'successfully updated']);
    }

    /**
     * @param redirect to topup request page
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
    */
    public function getTopupFundsRequestRedirect(Request $request, $id=null)
    {
        $request->session()->flash('statusUpdate', true);
        return redirect('/avanya-vip-portal/get-topup-request');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function topupExport($ext,Request $request)
    {
        if (!empty($ext)) {
            $headings = ['ID','Username','Amount','Processing Fees','Paid Amount','Topup Receipt','Process Receipt','Remarks','status','Date'];
            return Excel::download(new TopupExport($headings,$request->all()), 'topup-request_'.time().'.' . $ext);
        }
    }

    /**
     * return view
     */
    public function importTopupView()
    {
        return view('admin.topup.import_topup');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topupImport(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,xls,csv'
        ]);
        $fileName = $request->file;

        Excel::import(new TopupImport, $fileName);
        
        return back()->with(['message' => 'topup  request succesfully imported']);
    }
}