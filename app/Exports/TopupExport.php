<?php

namespace App\Exports;

use App\Models\TopupFund;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopupExport implements FromCollection,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($headings,$request)
    {
        $this->headings = $headings;
        $this->request = $request;
    }

    public function collection()
    {
    	// $trading = TopupFund::selectRaw('*,CASE When reciept_process!="" THEN CONCAT("'.asset('process_reciepts').'/",reciept_process) END as reciept_process,CASE When reciept_topup!="" THEN  CONCAT("'.asset('topup_reciepts').'/",reciept_topup) END as reciept_topup')->with('users')->whereHas('users');
    	$trading = TopupFund::with('users')->whereHas('users');

    	if(isset($this->request['username']) && $this->request['username']!=null ){
            $username = $this->request['username'];
            $trading =  $trading->whereHas('users',function($q1) use ($username ) {
                return $q1->where('user_name','like','%'.$username .'%');
            });
        }
        if(isset($this->request['start_date']) && $this->request['start_date'] && $this->request['end_date'] && $this->request['start_date']!="" && $this->request['end_date']!="" ){
            $trading =  $trading->whereRaw("Date(created_at) >= '".date('Y-m-d',strtotime($this->request['start_date']))."' and  Date(created_at) <= '".date('Y-m-d',strtotime($this->request['end_date']))."' ");   
        }
        $collection = $trading->get()->toArray();
        foreach ($collection as $key => $value) {
           
            $arr = [];
            $arr['id'] = $value['id'];
            $arr['user_id'] = $value['users']['user_name'];
            $arr['amount'] = (string)$value['amount'];
            $arr['processing_fees'] = (string)$value['processing_fees'];
            $arr['paid_amount'] = (string)$value['paid_amount'];
            $arr['reciept_topup'] = $value['reciept_topup']!=""?asset('topup_reciepts/'.$value['reciept_topup']):"";
            $arr['reciept_process'] = $value['reciept_process']!=""?asset('process_reciepts/'.$value['reciept_process']):"";
            $arr['remarks'] = $value['remarks'];
            $arr['status'] = $value['status']==1?"Approved":($value['status']==2?"Rejected":"Pending");
            $arr['date'] = date('Y-m-d',strtotime($value['created_at']));
            $collection[$key] = $arr;

        }                    
        // dd($collection,$this->request);
        // dd(collect($collection));
        return collect($collection);
    }
    public function headings(): array
    {
        return $this->headings;
    }
}
