<?php

namespace App\Http\Controllers;

use App\Models\LeadershipBonus;
use App\Models\LeadershipBreakDown;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class LeadershipBonusController
 * @package App\Http\Controllers
 */
class LeadershipBonusController extends AppBaseController
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
    public function leadershipBonus(Request $request)
    {
        $items = $request->items ?? 50;

        $totalCapital = User::find(auth::user()->id)->total_capital;

        $searchedDate = '';
        $query = LeadershipBonus::query();
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }
        $leadershipBonus = $query->where('user_id', auth::user()->id)->orderBy('created_at','desc')->paginate($items)->appends($request->except('_token'));
        $totalLeadershipBonus = LeadershipBonus::where('user_id',auth::user()->id)->sum('profit');
        return view('users.leadership_bonus', compact('leadershipBonus', 'totalCapital', 'searchedDate','totalLeadershipBonus'))
            ->withItems($items);;

    }

    public function getBreakDown(Request $request)
    {
        if (!empty($request)) {
            $breakdownDate = $request['date'];

            $data = LeadershipBreakDown::with('fromUser')
                ->where('created_at', $breakdownDate)
                ->where('user_id', auth::user()->id)
                ->get();

            return response()->json([
                'data' => $data,
                'success' => true,
            ]);
        }
    }

    public function getBreakDownByUsername(Request $request)
    {
        if (!empty($request)) {
            $breakdownDate = $request['date'];
            $username = $request['user_name'];

            $data = LeadershipBreakDown::with('fromUser')
                ->whereHas('fromUser', function ($q) use ($username) {
                    $q->where('user_name', 'like', "%{$username}%");
                })->where('created_at', $breakdownDate)
                ->where('user_id', auth::user()->id)
                ->get();

            return response()->json([
                'data' => $data,
                'success' => true,
            ]);
        }
    }
}
