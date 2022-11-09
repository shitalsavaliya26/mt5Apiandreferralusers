<?php

namespace App\Exports;

use App\Models\TraderHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class TraderReport implements FromCollection, WithHeadings
{
    public function __construct($headings,$request)
    {
        $this->headings = $headings;
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $traders_history = TraderHistory::where(function($query){
            $query->where('status',1)->orWhere('status',3);
        })->whereHas('get_user')->whereHas('traders');
        if (!empty($this->request['start_date']) && !empty($this->request['end_date'])) {
            $traders_history->whereBetween('created_at', [$this->request['start_date'], $this->request['end_date']]);
            $startdate = Carbon::parse($this->request['start_date'])->format('m/d/Y');
            $enddate = Carbon::parse($this->request['end_date'])->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
        }

        if (!empty($this->request['trader_id'])) {
            $traders_history->where('trader_id', $this->request['trader_id']);
            $searchedtrader_id = $this->request['trader_id'];
        }

        if (!empty($this->request['user_id'])) {
            $traders_history->where('user_id', $this->request['user_id']);
            $searcheduser_id = $this->request['user_id'];
        }

        $traders_history = $traders_history->orderBy('id','desc')->get();
        $traders_history->map(function ($history) {
            $enddate = ($history->end_date) ? $history->end_date : Carbon::now();
            $history->profit = $history->get_user->trading_profits()->whereBetween('created_at', [$history->start_date, $enddate])->sum('profit');
            $history->commission = ($history->profit > 0) ? (($history->profit*20)/100) : 0;
            $history->start_date = Carbon::parse($history->start_date)->format('d/m/Y');
            $history->end_date   = ($history->end_date) ? Carbon::parse($history->end_date)->format('d/m/Y') : 'Current';
            $history->amount     = $history->get_user->userwallet()->whereBetween('created_at', [$history->start_date, $enddate])->sum('topup_fund');
            return $history;
        });

        $collection = [];
        foreach ($traders_history as $key => $row) {
            $value['id'] = $row->id;
            $value['investor'] = $row->get_user->user_name;
            $value['mt5_username'] = ($row->traders->mt5_username) ?  $row->traders->mt5_username : 'N/A';
            $value['capital'] = number_format($row->amount,2);
            $value['date_from'] = $row->start_date;
            $value['date_to'] = $row->end_date;
            $value['trader'] = $row->traders->name;
            $value['total_investors'] = $row->traders->history()->where('status',1)->distinct('user_id')->count();
            $value['trading_profit'] = number_format($row->profit,2);
            $value['traders_commission'] = number_format($row->commission,2);

            $collection[$key]=$value;
        }                    
        return collect($collection);

    }

    public function headings(): array
    {
        return $this->headings;
    }
}
