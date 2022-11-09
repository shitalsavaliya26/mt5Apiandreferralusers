<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models as Model;
use  Helper;


class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function upgradeRanking(Request $request){
        try {
            $users = User::with('rank','userwallet')->where(['status'=>'active'])->get();
            foreach ($users as $key => $user) {
                /* Skip special rank and fixed ranking users */
                if($user->rank!=null && $user->rank->name == 'Diamond'){
                    continue;
                }
                $nextRank = Helper::getNewRank($user->rank_id);
                // $user->id = '15';
                $log_data['id'] = $user->id;
                $log_data['username'] = $user->user_name;
                $user_invest_amount = $user->total_deposite->sum('amount') - $user->total_deposite->sum('processing_fees');
                $user_downline_sales = $user->userwallet!=null?$user->userwallet->total_group_sale:0;
                $user_direct_downline = User::where('sponsor',$user->id)->where('rank_id','>=',$user->rank_id)->count();

               echo "<br>"."===================================";
                
                
                if($nextRank){
                    $is_upgrade = 1;
                    if($nextRank->direct_sale != 0  && $nextRank->direct_sale > $user_invest_amount){
                        echo "<br>"."nextRank->direct_sale >> ".$nextRank->direct_sale;
                        echo "<br>"."user_invest_amount >> ".$user_invest_amount;
                        $is_upgrade = 0;
                    }
                    if($nextRank->downline_sales != 0 && $nextRank->downline_sales > $user_downline_sales){
                        echo "<br>"."downline_sales >> ".$nextRank->downline_sales ;
                        echo "<br>"."user_downline_sales >> ".$user_downline_sales;
                        $is_upgrade = 0;
                    }
                    if($nextRank->direct_downline != 0 && $nextRank->direct_downline > $user_direct_downline){
                        echo "<br>"."nextRank->direct_downline >> ".$nextRank->direct_downline;
                        echo "<br>"."direct_downline >> ".$user_direct_downline;
                        $is_upgrade = 0;                    
                    }
                    if($is_upgrade == 1){
                        $rank_history = new Model\RankHistory();
                        $rank_history->user_id = $user->id;
                        $rank_history->rank_id = $nextRank->id;
                        $rank_history->old_rank_id = $user->rank_id;
                        $rank_history->type = 1;
                        $rank_history->save();
                        $user->rank_id = $nextRank->id;
                        $user->save();
                    }
                    
                }    
            }
        } catch (Exception $e) {
            Helper::createAdminLog('cron/upgrade_ranking',"",['Error'=>$e->getMessage(),'data'=>$user]);
            // continue;
        }
        
    }
}
