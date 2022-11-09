<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\sendUserNotification as sendUserNotification;
use App\Exports\WithdrawExport;
use App\Http\Controllers\AppBaseController;
use App\Imports\WithdrawImport;
use App\Models\UserWallet;
use App\Models\Wallet;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use App\User;
use App\Models\Setting;
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
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getWithdrawRequest(Request $request)
    {
        $query = Withdraw::has('users');
        $data = $request->all();
        $searchedDate = '';
        $name = '';
        
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);

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

	$withdraws = $query->orderby('id','desc')->paginate(8)->appends($request->except('_token'));

        if ($request->ajax()) {
            return view('admin.withdraws.table', compact('withdraws', 'searchedDate','name','data'));
        }

        return view('admin.withdraws.withdraw_request', compact('withdraws', 'searchedDate','name','data'));
    }


    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateWithdrawRequest($id)
    {
        $withdraw = Withdraw::find($id);

        return view('admin.withdraws.update_request', compact('withdraw'));
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateWithdrawStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'remarks' => 'required'
        ]);


        $input = $request->all();
        
        $withdraw_setting   =   Setting::first();

        $withdrawal_fees    =   $withdraw_setting->withdraw_fees;
        $withdraw = Withdraw::find($id);
        if( $input['status'] == '1'){
            $withdrawal_amount  =   $input['amount'];// - $withdrawal_fees;

        }else{
             $withdrawal_amount = $input['amount'];
        }
        $withdraw->update([
            'status'    => $input['status'],
            'remarks'   => $input['remarks'],
            'amount'    => $withdrawal_amount,
            'withdrawal_fees' => $withdrawal_fees
        ]);
        

        if ($input['status'] == 1) {
            $userWallet_check = UserWallet::where('user_id', $input['user_id'])->first(); 
            
            if($userWallet_check == null){
                $UserWallet = UserWallet::create([
                    'user_id' => $input['user_id'],
                ]);
            }

            UserWallet::where('user_id', $input['user_id'])->decrement('withdrawal', $input['amount']);

        }

        
        //Send mail notification
        if($input['status'] == 1){
            $content = 'Withdraw request has been Approved';
        }else{
            $content = 'Withdraw request has been Rejected';
        }
        $user = User::where('id',$input['user_id'])->first();
        $user->mail_content = $content;  
        $user->notify(new sendUserNotification($user));
        

        return redirect('avanya-vip-portal/get-withdraw-request')->with('message', 'Status successfully updated');
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBulkWithdrawStatus(Request $request)
    {
        $ids = $request->ids;
        $status = $request->status;
        $remarks = $request->remarks;

        DB::table("withdraws")->whereIn('id', explode(",", $ids))->update(['status' => $status, 'remarks' => $remarks]);

        $data = DB::table("withdraws")->whereIn('id', explode(",", $ids))->select('user_id','amount')->get();

        if ($request->status == 1) {

            foreach ($data as $key => $value) {
                $userWallet_check = UserWallet::where('user_id', $value->user_id)->first(); 
                if($userWallet_check == null){
                    $UserWallet = UserWallet::create([
                        'user_id' =>$value->user_id,
                    ]);
                }
                // Wallet::where('user_id', $value->user_id)->decrement('total_balance', $value->amount);
                UserWallet::where('user_id',$value->user_id)->decrement('withdrawal', $value->amount);
                /*$user = User::find($value->user_id);
                if ($user->total_capital == null) {
                    $user->update(['total_capital'=>$value->amount]);
                } else {
                    $user->decrement('total_capital',$value->amount);
                }*/
            }
        }

        return response()->json(['status' => true, 'message' => 'successfully updated']);
    }

    /**
     * @param redirect to withdraw request page
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
    */
    public function getTopupWithdrawRequestRedirect(Request $request, $id=null)
    {
        $request->session()->flash('statusUpdate', true);
        return redirect('/avanya-vip-portal/get-withdraw-request');
    }
    
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function withdrawExport($ext,Request $request)
    {
        if (!empty($ext)) {
            $headings = ['ID','Username','Amount','Withdrawal fees','Remarks','status','Date'];
            return Excel::download(new WithdrawExport($headings,$request->all()), 'withdraw-request_'.time().'.' . $ext);
        }
    }

    /**
     * return view
     */
    public function importWithdrawView()
    {
        return view('admin.withdraws.import_withdraw');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdrawImport(Request $request)
    {
        $request->validate([
            'file' => 'mimes:xlsx,xls,csv'
        ]);
        $fileName = $request->file;

        Excel::import(new WithdrawImport, $fileName);

        return back()->with(['message' => 'withdraw request successfully imported']);
    }
}
