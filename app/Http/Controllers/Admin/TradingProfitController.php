<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models as Model;
use App\User;
use Helper;
use GuzzleHttp\TransferStats;
use Excel;

use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
  
    public function model(array $row)
    {
        return new User([
            'id' => $row[0]
         ]);
    }
}

class TradingProfitController extends Controller
{
    public function __construct(Request $request){
        // parent::__construct();

	set_time_limit(0);
	ini_set('memory_limit'  ,'-1');

        $this->path = storage_path('logs/user_logs/'.date("Y-m-d").'.log');
        $this->limit = $request->limit?$request->limit:10;

    }
    public function p($data,$exit='1'){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($exit){
            exit();
        }
    }
    public function index(Request $request){
        $history_data = Model\TradingProfitImportFile::orderBy('id','desc')->paginate($this->limit);
        $trading_profit = Model\TradingProfit::with('users')->where('id','5')->first();

        return view('admin.trading_profit.index',compact('history_data'));
    }

    public function importFile(Request $request){	

        set_time_limit(0);
       
        if($request->file('importFile')->getClientOriginalExtension() != 'csv'){
            return redirect()->back()->with('error','The import file must be a file of type: csv.            ');
        }

	    $delimiters = array(
            'semicolon' => ";",
            'tab'       => "\t",
            'comma'     => ",",
        );
        $csv = file_get_contents($request->file('importFile'));
        foreach ($delimiters as $key => $delim) {
            $res[$key] = substr_count($csv, $delim);
        }
        arsort($res);
        reset($res);
        $first_key = key($res);

        if($first_key == 'comma'){
            return redirect()->back()->with('error','Upload valid csv file.');
        }

        try {
            if($request->file('importFile')){
                $original_name = $request->file('importFile')->getClientOriginalName();
                $original_extension = $request->file('importFile')->getClientOriginalExtension();
                $path = 'profit/import';
                $file_name = time().'_file.'.$original_extension;
                $image= $request->importFile->storeAs('profit/import',$file_name);
                $rebate_file = new Model\TradingProfitImportFile();
                $rebate_file->file_name = $file_name;
                $rebate_file->original_name = $original_name;
                $rebate_file->path  = $path;
                $rebate_file->save();

                $file_path = 'public/'.$rebate_file->path.'/'.$original_name;
                $this->calculateCommission($rebate_file->id,$request->file('importFile'),$file_path);
                return redirect()->back()->with('success','File imported successfully.');
            }
	    return redirect()->back()->with('error','Please select proper html files.');
        }catch(Exception $e){
		return redirect()->back()->with('error','Something went wrong.......');
        }
        // return view('backend.pipe_rebates.import_data');
    }

    public function calculateCommission($fileId,$file,$file_path){
        $array = Excel::toCollection(new UsersImport, $file);

        // $array = Excel::toCollection( new UsersImport, $file, \Maatwebsite\Excel\Excel::CSV);
        //    echo "<pre>";
        //    print_r($array->toArray());
        //    exit;
        if(!empty($array[0])){
            foreach($array[0] as $key => $value){
                if($key == 0 || $key == 1 ){
                    continue;
                }
                
                $userName = str_replace([' ',"\x00"],['',""],trim($value[0]));
                $login = str_replace([' ',"\x00"],['',""],trim($value[0]));

                // $userName = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', trim($value[0]));
                if($userName != "" || $userName != null){
                    $user = User::where(function($q) use($login,$userName){
                        $q->where('mt4_username',$login)->orWhere('user_name',$userName);
                    })->where(['status'=>'active'])->first();
                    if($user != null){                            
                        /** Trading Profit Calculation */
                        $profit =  (float)str_replace([' ',"\x00"],['',""],trim($value[10]));
                        if($profit > 0){
                            $this->tradingProfitCommission($user,$value,$fileId);
                        }

                    }
                }
            }
            $this->leader_bonus_update($fileId);
            $this->profit_sharing($fileId);
        }
        return;
    }
    
    
    /** Calculating trading profit commission [ 70% on Profit ] */
    public function tradingProfitCommission($user,$value,$file_data){
        $profit =  (float)str_replace([' ',"\x00"],['',""],trim($value[10]));
   
        $reb_comm_perc = 0;
        if($user->rank_detail == null){
            $rebate_comm_amt = 0;//$rowVals['amount'];
        }else{
            $rebate_comm_amt = round(($profit * 0.7),2);
        }
        $opt[] = [
                'mt4_id' => $user->mt4_user_id,
                'amount' => $rebate_comm_amt,
                'percent' => $reb_comm_perc,
                'rebate_amount' => $profit,
            ];
        /*continue;*/
        // $tradingProfit = new TradingProfit();
        // $tradingProfit->user_id = $user->id;
        // $tradingProfit->amount = round($profit,2);
        // $tradingProfit->percent = $reb_comm_perc;
        // $tradingProfit->profit_amount = round($rebate_comm_amt,2);
        // if(isset($file_data) && $file_data!=null){
        //     $tradingProfit->file_id = $file_data->id;
        // }
        // $tradingProfit->save();
        $TradingProfit = new Model\TradingProfit();
        $TradingProfit->user_id = $user->id;
        $TradingProfit->file_id = $file_data;
        $TradingProfit->profit = round($profit,2)*0.7;
        $TradingProfit->site_profit = round($profit,2)*0.3;
        $TradingProfit->residual = round($profit,2)*0.2;
        $TradingProfit->amount = round($profit,2);
        $TradingProfit->use_profit = 0;
        $TradingProfit->save();
        // $user[]=$TradingProfit;
        $userwallet = Model\UserWallet::firstOrCreate(['user_id'=>$user->id]);
        $userwallet->increment('withdrawal', $TradingProfit->profit);
        if($user->rank_id=='6' || ($user->rank!=null && $user->rank->name=='Diamond')){
           
            $OwnershipBonus = new Model\OwnershipBonus();
            $OwnershipBonus->user_id =  $user->id;
            $OwnershipBonus->commission =  round($TradingProfit->site_profit*0.02,2);
            $OwnershipBonus->amount = $TradingProfit->site_profit;
            $OwnershipBonus->percent = "2" ;
            // $OwnershipBonus->from_user_id = $user->id;
            $OwnershipBonus->file_id = $file_data;
            $OwnershipBonus->save();

            $TradingProfit->residual = $TradingProfit->residual - $OwnershipBonus->commission;
            $TradingProfit->save();
            $userwallet->increment('withdrawal', $OwnershipBonus->commission);
            $this->createTotal($OwnershipBonus->commission,'ownership_bonus',$user->id);
        }
        
        
        $this->createTotal($TradingProfit->profit,'trading_profit',$user->id);
        // $this->p("Trading Profit file_id:==".$file_data,0);
        $this->unilevel_bonus_update($file_data,$user,$TradingProfit);
        return;
    }

   
    public function unilevel_bonus_update($file_id,$user_detail,$trading_profit){
        // $this->p("unilevel_bonus_update file_id:==".$file_id,0);
        $uplines = Helper::getUplineUser($user_detail);
        $data=[];
        foreach ($uplines as $key => $value) {
            
            $commission =  $percentage = 0;
            if($value->direct_downline == '1'){
                $percentage = $value->rank->unilevel;
                $commission = ($trading_profit->profit)*($value->rank->unilevel)/100;
            }else if($value->direct_downline == '2'){
                $percentage = $value->rank->unilevel;
                $commission = ($trading_profit->profit)*($value->rank->unilevel) / 100 ;
            }else if($value->direct_downline >= '3'){
                $percentage = $value->rank->unilevel;
                $commission = ($trading_profit->profit)*($value->rank->unilevel)/100;
            }
            // echo "<br>User name".$value->user_name;
            // echo "<br>Rank name".$value->rank->name;
            // echo "<br>percentage".$percentage;
            if($commission <=0 ){
                continue;
            }
            $data[]=['user'=>$value,'percentage'=>$percentage,'commission'=>$commission];
            // $this->p($value,0);
            $unilevel = Model\UnilevelProfit::firstOrCreate(['user_id'=>$value->id,'file_id'=>$file_id]);
            $unilevel->profit = $unilevel->profit + $commission;
            $unilevel->amount = $unilevel->amount + $trading_profit->profit;
            $unilevel->save();

            $unilevelbreak = new Model\UnilevelBreakDown();
            $unilevelbreak->user_id =  $value->id;
            $unilevelbreak->commission =  $commission;
            $unilevelbreak->amount = $trading_profit->profit;
            $unilevelbreak->percentage = $percentage ;
            $unilevelbreak->from_user_id = $user_detail->id;
            $unilevelbreak->file_id = $file_id;
            $unilevelbreak->save();

            Model\TradingProfit::where(['file_id'=>$file_id,'user_id'=>$user_detail->id])->decrement('residual',$commission);

            $userwallet = Model\UserWallet::firstOrCreate(['user_id'=>$unilevelbreak->user_id]);
            
            $this->createTotal($unilevelbreak->amount,'unilevel',$user_detail->id);
            $userwallet->increment('withdrawal', $unilevelbreak->commission);
        }
        

    }
    public function leader_bonus_update($file_id){
        $user_ids = Model\UnilevelProfit::where("file_id",$file_id)->pluck('user_id');
        //$users = User::where('status','active')->whereIn('id',$user_id)->get();
        // dd($user_ids,$file_id);
	    $users = User::where('status','active')->whereIn('id',$user_ids)->get();
        foreach ($users as $key => $user_detail) {
            if($user_detail->rank == null){
                // continue;
            }
            $uplines = Helper::getUplineUser($user_detail);
            $trading_profit = Model\TradingProfit::where("file_id",$file_id)->where('user_id',$user_detail->id)->first();
            foreach ($uplines as $key => $value) {

                $commission =  $percentage = 0;
                if($value->rank == null){
                    continue;
                }
                if($value->rank->leader_bonus > 0){
                    $percentage = $value->rank->leader_bonus;
                    $commission = ($trading_profit->profit)*($value->rank->leader_bonus) / 100 ;
                }else{
                    $percentage = 0;
                    $commission = 0;
                }
                if($commission <=0 ){
                    continue;
                }

                $leadership = Model\LeadershipBonus::firstOrCreate(['user_id'=>$value->id,'file_id'=>$file_id]);
                $leadership->profit = $leadership->profit + $commission;
                $leadership->amount = $leadership->amount + $trading_profit->profit;
                $leadership->save();

                $unilevelbreak = new Model\LeadershipBreakDown();
                $unilevelbreak->user_id =  $value->id;
                $unilevelbreak->commission =  $commission;
                $unilevelbreak->amount = $trading_profit->profit;
                $unilevelbreak->percentage = $percentage ;
                $unilevelbreak->from_user_id = $user_detail->id;
                $unilevelbreak->file_id = $file_id;
                $unilevelbreak->save();
                $userwallet = Model\UserWallet::firstOrCreate(['user_id'=>$unilevelbreak->user_id]);
                $this->createTotal($unilevelbreak->amount,'leadership_bonus',$user_detail->id);
                $userwallet->increment('withdrawal', $unilevelbreak->commission);
                Model\TradingProfit::where(['file_id'=>$file_id,'user_id'=>$user_detail->id])->decrement('residual',$commission);
            }
        }
        
    }
    
    public function profit_sharing($file_id){
        $user_ids = Model\UnilevelProfit::where("file_id",$file_id)->pluck('user_id');
        //$users = User::where('status','active')->whereIn('id',$user_id)->get();

        $users = User::where('status','active')->whereIn('id',$user_ids)->get();
        foreach ($users as $key => $user_detail) {
            
            $uplines = Helper::getUplineUser($user_detail);
            // echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
            $trading_profit = Model\UnilevelProfit::where("user_id",$user_detail->id)->where("file_id",$file_id)->first();
            // $this->p(["Username"=>$user_detail->user_name,'uplines'=>$uplines,'trading_profit'=>$trading_profit],0);
            foreach ($uplines as $key => $value) {
                if($value->rank == null){
                    continue;
                }
                if($value->rank == null){
                    continue;
                }
                if($value->rank->leader_bonus > 0){
                    $percentage = $value->rank->profit_sharing;
                    $commission = ($trading_profit->profit)*($value->rank->profit_sharing) / 100 ;
                }else{
                    $percentage = 0;
                    $commission = 0;
                }
                if($commission <=0 ){
                    continue;
                }
                $profit_sharing = Model\ProfitSharing::firstOrCreate(['user_id'=>$value->id,'file_id'=>$file_id]);
                $profit_sharing->profit = $profit_sharing->profit + $commission;
                $profit_sharing->amount = $profit_sharing->amount + $trading_profit->profit;
                $profit_sharing->save();

                $unilevelbreak = new Model\ProfitSharingBreakDown();
                $unilevelbreak->user_id =  $value->id;
                $unilevelbreak->commission =  $commission;
                $unilevelbreak->amount = $trading_profit->profit;
                $unilevelbreak->percentage = $percentage ;
                $unilevelbreak->from_user_id = $user_detail->id;
                $unilevelbreak->file_id = $file_id;
                $unilevelbreak->save();
                $userwallet = Model\UserWallet::firstOrCreate(['user_id'=>$unilevelbreak->user_id]);
                $this->createTotal($unilevelbreak->amount,'profit_sharing',$user_detail->id);
                Model\TradingProfit::where(['file_id'=>$file_id,'user_id'=>$user_detail->id])->decrement('residual',$commission);
                $userwallet->increment('withdrawal', $unilevelbreak->commission);
            }
            // dd(" ProfitSharing Complete");
        }
    }
        
    /**
     *  Total create in table
     */
    protected function createTotal($amount,$wallet,$user_id){
        $commission = Model\TotalReport::firstOrCreate(['user_id'=>$user_id,'profit_date'=>date('Y-m-d')]);
        $commission->user_id = $user_id;
        if($wallet == 'trading_profit'){
            $commission->trading_profit = $commission->trading_profit + $amount;
        }
        if($wallet == 'unilevel'){
            $commission->unilevel = $commission->unilevel + $amount;
        }
        if($wallet == 'leadership_bonus'){
            $commission->leadership_bonus = $commission->leadership_bonus + $amount;
        }
        if($wallet == 'profit_sharing'){
            $commission->profit_sharing = $commission->profit_sharing + $amount;
        }
        if($wallet == 'ownership_bonus'){
            $commission->ownership_bonus = $commission->ownership_bonus + $amount;
        }
        $commission->total = $commission->total + $amount;
        $commission->save(); 
    }
    Public function readercacl(array $row){

        $results = $reader->toArray();
        if(!empty($results)){
            foreach($results as $key => $value){
                $userName = trim($value['name']);
                $login = trim($value['login']);
                
                if($userName != "" || $userName != null){
                    $user = User::with('userwallet','rank_detail')->where(function($q) use($login,$userName){
                        $q->where('mt4_user_id',$login)->orWhere('username',$userName);
                    })->where(['is_deleted'=>'0','status'=>'active'])->first();
                    
                    if($user != null){                            
                        /** Trading Profit Calculation */
                        $profit =  (float)str_replace([' ',"\x00"],['',""],trim($value[]));
                        if($profit > 0){
                            $this->tradingProfitCommission($user,$value);
                        }
                    }
                }
            }
            $this->leader_bonus_update($fileId);
        }
    }
}
