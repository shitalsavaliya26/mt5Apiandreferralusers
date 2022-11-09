<?php

namespace App\Exports;

use App\Models\TradingProfit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TradingProfitReportExport implements FromCollection, WithHeadings
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
        // dd($this->request);
        $trading = TradingProfit::select('*')->whereHas('users')->with('users');
        if($this->request['username'] && $this->request['username']!=null ){
            $trading =  $trading->whereHas('users',function($q1){
                return $q1->where('user_name',$this->request['username']);
            });
        }
        if($this->request['start_date'] && $this->request['end_date'] && $this->request['start_date']!="" && $this->request['end_date']!="" ){
            $trading =  $trading->whereRaw(" Date(created_at) >= '".date('Y-m-d',strtotime($this->request['start_date']))."' and  Date(created_at) <= '".date('Y-m-d',strtotime($this->request['end_date']))."' ");   
        }
        $collection = $trading->get()->toArray();
        foreach ($collection as $key => $value) {
            $value['user_id'] = $value['users']['user_name'];
            $value['date'] = date('Y-m-d',strtotime($value['created_at']));
            unset($value['users'],$value['created_at'],$value['updated_at']);
            $collection[$key]=$value;
        }                    
        return collect($collection);

    }

    public function headings(): array
    {
        return $this->headings;
    }
}
