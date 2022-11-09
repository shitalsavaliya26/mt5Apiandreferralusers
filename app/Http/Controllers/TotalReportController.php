<?php

namespace App\Http\Controllers;

use App\Models\TotalReport;
use App\User;
use App\Models\TradingProfit;
use App\Models\UnilevelProfit;
use App\Models\ProfitSharing;
use App\Models\OwnershipBonus;
use App\Models\LeadershipBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class TotalReportController
 * @package App\Http\Controllers
 */
class TotalReportController extends AppBaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * return view my profile
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function totalReport(Request $request)
    {
        $items = $request->items ?? 50;

        $totalCapital = User::find(auth::user()->id)->total_capital;

        $searchedDate = $i = '';
        $query = TotalReport::query();
        
        if (!empty($request->start_date) && !empty($request->end_date)) {
            
            $startDate = new \DateTime($request->start_date);
            $startDate = $startDate->format('Y-m-d');

            $endDate = new \DateTime($request->end_date);
            $endDate = $endDate->format('Y-m-d');

            if ($startDate == $endDate) {
                $query = $query->whereDate('created_at', $startDate);
            } else {
                $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
            $i = $query->count();
        }
        
        $totalReports = $query->where('user_id', auth::user()->id)->orderBy('created_at','desc')->paginate($items)->appends($request->except('_token'));

        $totalTradingProfit = TradingProfit::where('user_id',auth::user()->id)->sum('profit');
        
        $totalUnilevels = UnilevelProfit::where('user_id',auth::user()->id)->sum('profit');

        $totalProfitSharing = ProfitSharing::where('user_id',auth::user()->id)->sum('profit');

        $totalLeadershipBonus = LeadershipBonus::where('user_id',auth::user()->id)->sum('profit');
        
        $totalOwnershipBonus = OwnershipBonus::where('user_id',auth::user()->id)->sum('profit');

        $totalReportSum = $totalTradingProfit + $totalUnilevels + $totalProfitSharing + $totalLeadershipBonus + $totalOwnershipBonus;
        
        return view('users.total_report', compact('totalReports', 'totalCapital', 'searchedDate','i','totalTradingProfit','totalUnilevels','totalProfitSharing','totalLeadershipBonus','totalOwnershipBonus','totalReportSum'))
            ->withItems($items);
    }

}
