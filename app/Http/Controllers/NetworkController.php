<?php

namespace App\Http\Controllers;

use App\Models\NetworkTree;
use App\Models\Rank;
use App\Models\SaleReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class NetworkController
 * @package App\Http\Controllers
 */
class NetworkController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * return view my profile
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function networkTree(Request $request)
    {
        $ranks = Rank::get()->pluck('name');

        $query = NetworkTree::has('refferalName');

        if (!empty($request->user_name)) {
            $userName = $request->user_name;
            $query = $query->whereHas('refferalName', function ($q) use ($userName) {
                $q->where('user_name', 'like', "%{$userName}%");
            });
        }

        $networkTress = $query->where('parent_id', auth::user()->id)->get();

        return view('users.network_tree', compact('networkTress','ranks'));
    }

    /**
     * return view my profile
     */
    public function getDownLine(Request $request)
    {
        if (!empty($request)) {

            $downlineUser = $request->downline;
            $downlineDetail = NetworkTree::where('refferal_id', $downlineUser)->first();
            $downlines = NetworkTree::with('refferalName')->where('parent_id', $downlineUser)->get();

            return response()->json([
                'success' => true,
                'details' => $downlineDetail,
                'downlines' => $downlines

            ]);
        }
    }

    /**
     * return view my profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDownLineViewHistory(Request $request)
    {
        if (!empty($request)) {
            $userId = $request->user_id;

            $monthlyReports = SaleReport::where('user_id', $userId)->get();

            return response()->json([
                'success' => true,
                'data' => $monthlyReports,
            ]);
        }
    }
}
