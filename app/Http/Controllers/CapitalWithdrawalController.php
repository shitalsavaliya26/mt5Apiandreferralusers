<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Model;
use App\CapitalWithdrawal;
use Helper;
use Auth;
use Mail;

class CapitalWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $traders = Model\TraderHistory::with(['traders'=>function($q1){
                    return $q1->with('translation');
                }])->where('user_id',auth()->id())->whereIn('status',['1'])->get();

        $capital_withdraw = CapitalWithdrawal::where('user_id',Auth::user()->id)
        ->orderBy('id','desc')
        ->paginate(10);

        return view('capital-withdrawal.index',compact('data','traders','capital_withdraw'));
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
        $request->validate([
            'choose_trader' => 'required',
            'amount' => 'required|numeric'
        ]);

        $checkStatus = CapitalWithdrawal::where('user_id',Auth::user()->id)
            ->where('status','0')
            ->count();
        if ($checkStatus) {
            return redirect()->back()->with('error', 'You have already pending request.');
        }

        $input = $request->all();
        $input['user_id']   = Auth::user()->id;
        $input['trader_id'] = $request->choose_trader;

        CapitalWithdrawal::create($input);

        //Send mail notification    
        $data['user_id'] = $input['user_id'];
        $data['subject'] = 'Capital withdraw request has been received';
        $data['content'] = 'Capital withdraw request has been sent by {{USERNAME}}';

        Helper::sendAdminNotification($data);

        return redirect()->back()->with('message', 'Capital Withdraw request has been sent.');
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
