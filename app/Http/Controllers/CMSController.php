<?php

namespace App\Http\Controllers;

use App\Models\CMS;
use Illuminate\Http\Request;
use Response;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CMSController extends AppBaseController
{
    /**
     * Display a listing of the Post.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $selectedYear = $month = $language ='';
        $items = $request->items ?? 5;
        $searchedDate = '';
        $query = CMS::query();

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
        }

        if (!empty($request->language)) {
            $language = $request->language;
            $query = $query->where('language', $language);
        }

        if (!empty($request->year)) {
            $year = $request->year;
            $query = $query->whereYear('created_at', $year);
        }

        if (!empty($request->month)) {
            $month = $request->month;
            $query = $query->whereMonth('created_at', $month);
        }

        $cms = $query->where('status', 0)->paginate($items)->appends($request->except('_token'));
        return view('cms.all_cms', compact('searchedDate','cms','month','selectedYear','language'))->withItems($items);
    }
}
