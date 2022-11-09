<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection,WithHeadings
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
    	$trading = User::with('country','rank','sponsor_detail');
    	if(isset($this->request['global_search']) && $this->request['global_search']!=null ){

            $userName = $this->request['global_search'];
            $trading =  $trading->where('user_name', 'like', "%{$userName}%")->orWhere('full_name', 'like', "%'{$userName}'%")->orWhere('mt4_username', $this->request['global_search']);
        }
        if($this->request['start_date'] && $this->request['end_date'] && $this->request['start_date']!="" && $this->request['end_date']!="" ){
            $trading =  $trading->whereRaw(" Date(created_at) >= '".date('Y-m-d',strtotime($this->request['start_date']))."' and  Date(created_at) <= '".date('Y-m-d',strtotime($this->request['end_date']))."' ");   
        }
        $collection = $trading->get()->toArray();
        foreach ($collection as $key => $value) {
        	$arr = [];
            $arr['id'] = $value['id'];
            $arr['sponsor_name'] = $value['sponsor_detail']!=null?trim($value['sponsor_detail']['user_name']):"";
            $arr['full_name'] = trim($value['full_name']);
            $arr['username'] = trim($value['user_name']);
            $arr['email'] = trim($value['email']);
            $arr['identification_number'] = (string)trim($value['identification_number']);
            $arr['address'] = $value['address'];
            $arr['city'] = $value['city'];
            $arr['state'] = $value['state'];
            $arr['country'] = $value['country']['name'];
            $arr['phone_number'] = (string)$value['phone_number'];
            $arr['mt4_username'] = trim($value['mt4_username']);
            $arr['mt4_password'] = $value['mt4_password'];
            $arr['rank_name'] = $value['rank']!=null?$value['rank']['name']:"";
            $arr['status'] = $value['status'];
            $arr['reg_data'] = date('Y-m-d',strtotime($value['created_at']));//date('Y-m-d',strtotime($value['created_at']));
            $collection[$key] = $arr;
        }
        // dd($collection);                    
        // return User::all();
        return collect($collection);
    }
    public function headings(): array
    {
        return $this->headings;
    }
}
