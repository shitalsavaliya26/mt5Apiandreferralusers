<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\sendUserNotification as sendUserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CapitalWithdrawal;
use App\Models\UserWallet;
use App\Models as Model;
use App\Http\Controllers\AppBaseController;
use App\User;
use Helper;
use Mail;

class CapitalWithdrawController extends AppBaseController
{
     public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->userRepository = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $capital_withdraw = CapitalWithdrawal::orderBy('id','desc')->paginate(50);
        return view('admin.admin_capital_withdraw',compact('capital_withdraw'));
    }

    public function change_status(Request $request){
        $capital_withdraw = CapitalWithdrawal::find($request->id);
        if($capital_withdraw){

            //Send mail notification
            if($request['status'] == 1){
                $content = 'Capital withdraw request has been Approved';
            }else{
                $content = 'Capital withdraw request has been Rejected';
            }
            $user = User::where('id',$capital_withdraw->user_id)->first();
            $user->mail_content = $content;
            $user->notify(new sendUserNotification($user));
            

            $capital_withdraw->status = $request->status;
            $capital_withdraw->save();
            
            if($request->status == '1'){

                $history = Model\TraderHistory::where('user_id',$capital_withdraw->user_id)->where('trader_id',$capital_withdraw->trader_id)->first();
                if($history!=null){
                    // if($history->amount > $capital_withdraw->amount)){
                        $history->decrement('amount',$capital_withdraw->amount);
                    // }else{
                    //     $history->delete();
                    // }
                }
                $mt5Obj = new \App\Http\Controllers\MT5Controller;
                $depositData = [
                        'servername' => 'mt5demo.icdx.co.id:443',
                        'auth_login' => 10032,
                        'auth_password' => 'QNWBKD#2020',
                        "login"=>(int)$capital_withdraw->get_user_details->mt4_username,
                        "type"=>2,
                        // "type"=>3,
                        "amount"=> '-'.round($capital_withdraw->amount,2),
                        "comment"=> "Capital Withdraw"
                        
                ];
                $response = $mt5Obj->depositeAmount($depositData); 
                UserWallet::where('user_id',$capital_withdraw->user_id)->decrement('topup_fund', $capital_withdraw->amount);
                UserWallet::where('user_id',$capital_withdraw->user_id)->increment('withdrawal', $capital_withdraw->amount);
                // dd($depositData);
                $message = 'approved';
            }else{
                $message = 'rejected';
            }

           return redirect()->back()->with('message','Capital withdraw request '.$message.' successfully');
        }

        return redirect()->back()->with('errorFails','Something went wrong.! Please try again.');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
