<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\TraderReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TraderHistory;
use App\Models\Trader;
use Carbon\Carbon;
use App\User;

class TraderReportController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request){
    	$searchedDate = $searcheduser_id = $searchedtrader_id = '';

        $traders_history = TraderHistory::where(function($query){
            $query->where('status',1)->orWhere('status',3);
        })->whereHas('get_user')->whereHas('traders');
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $traders_history->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        if (!empty($request->trader_id)) {
            $traders_history->where('trader_id', $request->trader_id);
            $searchedtrader_id = $request->trader_id;
        }

        if (!empty($request->user_id)) {
            $traders_history->where('user_id', $request->user_id);
            $searcheduser_id = $request->user_id;
        }

        $traders_history = $traders_history->orderBy('id','desc')->paginate(50);
        
        $traders_history->getCollection()->transform(function ($history) {
        	$enddate = ($history->end_date) ? $history->end_date : Carbon::now();
        	$history->profit = $history->get_user->trading_profits()->whereBetween('created_at', [$history->start_date, $enddate])->sum('profit');
        	$history->commission = ($history->profit > 0) ? (($history->profit*20)/100) : 0;
        	$history->start_date = Carbon::parse($history->start_date)->format('d/m/Y');
        	$history->end_date   = ($history->end_date) ? Carbon::parse($history->end_date)->format('d/m/Y') : 'Current';
            $history->amount     = $history->get_user->userwallet()->whereBetween('created_at', [$history->start_date, $enddate])->sum('topup_fund');
            return $history;
        });
        $traders   = Trader::get();
        $investors = User::whereHas('history')->get();

        return view('admin.admin_trader_report', compact('searchedDate','traders','investors','searchedtrader_id','searcheduser_id','traders_history'));
    }

    public function traderReport(Request $request){
        // print_r($request->all());die();
       $headings = ['Id', 'Investor', 'Trader MT5 ID', 'Capital', 'Date From', 'Date To', 'Trader', 'Total Investers','Trading Profit','Traders Commission'];

       return Excel::download(new TraderReport($headings,$request->all()), 'trader_report_'.time().'.xlsx');
   }
}
