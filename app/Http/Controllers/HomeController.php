<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\PayoutReport;
use App\Models\Rank;
use App\Models as Model;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Support;
use App\Models\TicketMessage;
use App\Models\UserWallet;
use App\Models\NetworkTree;
use App\Models\TradingProfit;
use App\Models\UnilevelProfit;
use App\Models\ProfitSharing;
use App\Models\LeadershipBonus;
use App\Models\TotalReport;
use App\Models\OwnershipBonus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::where('language',app()->getLocale())->latest()->limit(3)->get();
        $currentRank = User::with('rank')->where('id', auth::user()->id)->first()->rank;
        if (!empty($currentRank)) {
            $nextRank = Rank::where('id', '>', $currentRank->id)->orderby('id', 'asc')->first();
        }
        $currentRank = $currentRank!=null ? $currentRank->name: "";

        $tradingProfit = TradingProfit::where('user_id',auth::user()->id)->sum('profit');
        $unilevel = UnilevelProfit::where('user_id',auth::user()->id)->sum('profit');
        $profitSharing = ProfitSharing::where('user_id',auth::user()->id)->sum('profit');
        $leadershipBonus = LeadershipBonus::where('user_id',auth::user()->id)->sum('profit');
        $ownershipBonus = OwnershipBonus::where('user_id',auth::user()->id)->sum('profit');
        $personalProfit = $tradingProfit + $unilevel + $leadershipBonus + $profitSharing;

        /*****/
        $directDownline = \Helper::getDownline(auth::user()->id);
        $UserWallet = UserWallet::where('user_id',auth::user()->id)->first();

        $refIds = [];
        $totalDownlines = 0;

        $networkTress = \Helper::getAllDownline(auth::user()->id);
        // dd($networkTress);
        foreach ($networkTress as $key => $value) {
            array_push($refIds, $value['id']);
        }
        $totalDownlines += count($networkTress);        
        
        array_push($refIds, auth::user()->id);
        $uniqueRefIds = array_unique($refIds);
        $allUserWallet = UserWallet::whereIn('user_id',$uniqueRefIds)->get();
        $totalFund = 0;
        foreach ($allUserWallet as $key => $value) {
            $totalFund += $value->topup_fund;
        }
        $history = Model\TraderHistory::where('user_id',auth()->id())->count();
        $funds = Model\TopupFund::where('user_id',auth()->id())->where('status','1')->count();
        if(($funds > 0 || $UserWallet->topup_fund > 0) && $history<=0){
            $showPopup = 1;
        }else{

            $showPopup = 0;
        }
        /*****/
        return view('users.home', compact('news', 'currentRank', 'tradingProfit', 'unilevel', 'leadershipBonus', 'ownershipBonus', 'profitSharing', 'nextRank', 'personalProfit','directDownline','UserWallet','totalDownlines','totalFund','showPopup'));
    }

    public function getChartDetails()
    {
        $displayDate = $months = $monthDate = array();
        $subMonth = Carbon::now()->addMonth(1);

        for ($i = 0; $i < 5; $i++) {
            $monthDate [] = $subMonth->format('Y-m-d H:i:s');
            $months[] = $subMonth->subMonth(1)->format('M');
        }

        $monthsWiseRecords = TotalReport::where('user_id', auth::user()->id)
            ->select(\DB::raw("MONTHNAME(created_at) month"), \DB::raw("trading_profit,unilevel,leadership_bonus,profit_sharing,total"))
            ->whereBetween('created_at', [$monthDate[4], $monthDate[0]])
            ->get()
            ->unique('month');

        $monthlyProfit = array();
        foreach ($monthsWiseRecords as $p) {
            $monthlyProfit [] = $p->total;
        }

        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');

        $period = CarbonPeriod::create($weekStartDate, $weekEndDate);

        foreach ($period as $date) {
            $displayDate[] = $date->format('d-m-Y');
        }

        $payouts = TotalReport::where('user_id', auth::user()->id)
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->get()
            ->unique('created_at');

        $dailyProfit = array();
        foreach ($payouts as $p) {
            $dailyProfit [] = $p->total;
        }

        $response = [
            'status' => 'success',
            'data' => $displayDate,
            'profit' => $dailyProfit,
            'months' => $months,
            'monthlyProfit' => $monthlyProfit
        ];
        return Response::json($response);
    }
}
