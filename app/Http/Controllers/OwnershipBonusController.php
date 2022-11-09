<?php

namespace App\Http\Controllers;

use App\Models\OwnershipBonus;
use App\Models\OwnershipBreakDown;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class OwnershipBonusController
 * @package App\Http\Controllers
 */
class OwnershipBonusController extends AppBaseController
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
    public function ownershipBonus(Request $request)
    {
        $totalCapital = User::find(auth::user()->id)->total_capital;

        $items = $request->items ?? 50;

        $searchedDate = '';
        $query = OwnershipBonus::query();
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }
        $ownershipBonus = $query->where('user_id', auth::user()->id)
            ->orderBy('created_at','desc')->paginate($items)->appends($request->except('_token'));
        $totalOwnershipBonus = OwnershipBonus::where('user_id',auth::user()->id)->sum('commission');
        return view('users.ownership_bonus', compact('ownershipBonus', 'totalCapital', 'searchedDate','totalOwnershipBonus'))
            ->withItems($items);
    }

    public function getBreakDown(Request $request)
    {
        if (!empty($request)) {
            $breakdownDate = $request['date'];

            $data = OwnershipBreakDown::with('fromUser')
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

            $data = OwnershipBreakDown::with('fromUser')
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
