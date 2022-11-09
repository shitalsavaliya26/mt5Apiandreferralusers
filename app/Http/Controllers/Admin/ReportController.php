<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadershipBonusReportExport;
use App\Exports\OwnershipBonusReportExport;
use App\Exports\ProfitSharingReportExport;
use App\Exports\TotalBonusReportExport;
use App\Exports\TradingProfitReport;
use App\Exports\TradingProfitReportExport;
use App\Exports\UnilevelReportExport;
use App\Http\Controllers\AppBaseController;
use App\Models\PayoutReport;
use App\Models\TotalReport;
use App\Models as Model;
use App\Repositories\RankRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

/**
 * Class ReportController
 * @package App\Http\Controllers
 */
class ReportController extends AppBaseController
{

    public function __construct(RankRepository $rankRepo)
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the Rank.
     * GET|HEAD /ranks
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payoutReport(Request $request)
    {
        $searchedDate = $searchedUserName = '';
        $query = TotalReport::has('users');

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        if (!empty($request->user_name)) {
            $searchedUserName = $request->user_name;
            $query = $query->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
        }

        $payouts = $query->select('*')->distinct()->paginate(50)->appends($request->except('_token'));


        return view('admin.reports.payout_report', compact('payouts', 'searchedDate', 'searchedUserName'));
    }

    public function getPayoutBreakDown(Request $request)
    {
        if (!empty($request)) {
            $userId = $request['user_id'];

            $data = TotalReport::where('user_id', $userId)->get();

            return response()->json([
                'data' => $data,
                'success' => true,
            ]);
        }
    }

    public function getAllReports(Request $request)
    {
        $data = $request->all();
        $total = TotalReport::whereHas('users');
        $profit = Model\ProfitSharing::whereHas('users');
        $leadership = Model\LeadershipBonus::whereHas('users');
        $ownership = Model\OwnershipBonus::whereHas('users');
        $trading = Model\TradingProfit::whereHas('users');
        $unilevel = Model\UnilevelProfit::whereHas('users');

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startdate = Carbon::parse($request->start_date)->format('Y-m-d');
            $enddate = Carbon::parse($request->end_date)->format('Y-m-d');
            $searchedDate = $startdate . ' - ' . $enddate;
            $data['searchedDate'] = $searchedDate;
            $total = $total->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $profit = $profit->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $leadership = $leadership->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $ownership = $ownership->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $trading = $trading->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $unilevel = $unilevel->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }else{
            $startdate = Carbon::now()->subDays(7)->format('Y-m-d');
            $enddate = Carbon::now()->format('Y-m-d');
            $searchedDate = $startdate . ' - ' . $enddate;
            $data['searchedDate'] = $searchedDate;
            $data['start_date'] = $startdate;
            $data['end_date'] = $enddate;
            $total = $total->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $profit = $profit->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $leadership = $leadership->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $ownership = $ownership->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $trading = $trading->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $unilevel = $unilevel->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        // dd($data);

        if (!empty($request->username)) {
            $searchedUserName = $request->username;
            $total = $total->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
            $profit = $profit->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
            $leadership = $leadership->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
            $ownership = $ownership->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
            $trading = $trading->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
            $unilevel = $unilevel->whereHas('users', function ($q) use ($searchedUserName) {
                $q->where('user_name', 'like', "%{$searchedUserName}%");
            });
        }

        $reports = $total->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        $profit = $profit->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        $leadership = $leadership->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        $ownership = $ownership->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        $trading = $trading->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        $unilevel = $unilevel->orderBy('created_at','desc')->paginate(5000)->appends($request->all());
        return view('admin.reports.index',compact('reports','data','profit','leadership','ownership','trading','unilevel'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function tradingProfit(Request $request)
    {
        $headings = ['Id', 'Username', 'File Id', 'Profit', 'Site Profit', 'Use Profit', 'Amount', 'Date'];

        return Excel::download(new TradingProfitReportExport($headings,$request->all()), 'trading_profit_'.time().'.xlsx');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function unilevel(Request $request)
    {
        $headings = ['Id', 'Username', 'File id', 'Profit', 'Amount', 'Date'];

        return Excel::download(new UnilevelReportExport($headings,$request->all()), 'unilevel_'.time().'.xlsx');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function profitSharing(Request $request)
    {
        $headings = ['Id', 'Username', 'File Id', 'Profit', 'Amount', 'Date'];

        return Excel::download(new ProfitSharingReportExport($headings,$request->all()), 'profit_sharing_'.time().'.xlsx');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function leadershipBonus(Request $request)
    {
        $headings = ['Id', 'Username', 'File Id', 'Profit', 'Amount', 'Date'];

        return Excel::download(new LeadershipBonusReportExport($headings,$request->all()), 'leadership_bonus_'.time().'.xlsx');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function ownershipBonus(Request $request)
    {
        $headings = ['Id', 'Username', 'Profit', 'Amount', 'Date'];

        return Excel::download(new OwnershipBonusReportExport($headings,$request->all()), 'ownership_bonus_'.time().'.xlsx');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function totalReports(Request $request)
    {
        $headings = [
            'Id',
            'Username',
            'Trading Profit',
            'Unilevel',
            'Profit Sharing',
            'Leadership Bonus',
            'Ownership Bonus',
            'Total',
            'Date'
        ];

        return Excel::download(new TotalBonusReportExport($headings,$request->all()), 'total_bonus_'.time().'.xlsx');
    }
}
