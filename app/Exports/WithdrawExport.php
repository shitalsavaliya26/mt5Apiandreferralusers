<?php

namespace App\Exports;

use App\Models\Withdraw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class WithdrawExport implements FromCollection,WithHeadings
{
	 /**
     * @return \Illuminate\Support\Collection
     */
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
    	$trading = Withdraw::with('users')->whereHas('users');

    	if(isset($this->request['username']) && $this->request['username']!=null ){
            $username = $this->request['username'];
            $trading =  $trading->whereHas('users',function($q1) use($username){
                return $q1->where('user_name',$username);
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
            $arr['amount'] = $value['amount'];
            $arr['withdrawal_fees'] = (string)$value['withdrawal_fees'];
            $arr['remarks'] = $value['remarks'];
            $arr['status'] = $value['status']==1?"Approved":($value['status']==2?"Rejected":"Pending");
            $arr['date'] = date('Y-m-d',strtotime($value['created_at']));
            $collection[$key] = $arr;
        }                    
        // dd(collect($collection));
        return collect($collection);
        // return Withdraw::all();
    }
    public function headings(): array
    {
        return $this->headings;
    }
}
