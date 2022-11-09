<?php
// namespace App\Helpers;

use App\Models as Model;
use App\User;

class Helper
{
    /**
     * @param int $user_id User-id
     *
     * @return string
     */
    public function __construct()
    {


    }

    public static function ic_number_verification($icnumber, $sponser_name)
    {
        $count = User::where('identification_number', $icnumber)->where(['status' => 'active', 'is_deleted' => '0'])->count();
        $sponser_details = User::where('username', $sponser_name)->first();
        $exists = 0;
        if ($count > 0) {
            $user_ids = User::where('identification_number', $icnumber)->where(['status' => 'active', 'is_deleted' => '0'])->pluck('id');

            $downline_ids = Model\UserReferral::where('user_id', $sponser_details->id)->value('downline_ids');

            $normal_count = 0;
            $downline_count = 0;
            if ($downline_ids != null && count($downline_ids) > 0) {
                foreach ($user_ids as $key => $value) {
                    if ($downline_count >= 3 || $normal_count >= 3) {
                        $exists = 1;
                        break;
                    }
                    if (in_array($value, $downline_ids)) {
                        $downline_count++;
                    } else {
                        $normal_count++;
                    }
                }
                if ($downline_count >= 3 || $normal_count >= 1) {
                    $exists = 1;
                }
                // dd(['downline_count'=>$downline_count,'normal_count'=>$normal_count,'exists'=>$exists]);
            } else {
                $exists = 1;
            }
            // dd(['exists'=>$exists]);
        }
        if ($exists) {
            return true;
        } else {
            return false;
        }

    }

    public static function checkHigherRanking($rank1, $rank2)
    {
        $ranks = [];
        $rank_detail = Model\Rank::all()->toArray();
        foreach ($rank_detail as $key => $value) {
            $ranks[$value['id']] = $value['id'];
        }
        if (array_search($rank1, $ranks) >= array_search($rank2, $ranks)) {
            return true;
        } else {
            return false;
        }
    }

    public static function activeDownline($user_id)
    {
        $downlines = User::where('sponsor',$user_id)->whereHas('userwallet',function($q1){
            return $q1->where('topup_fund','>=','5000');
        });

        return $downlines->count();
    }

    /* Return Next Rank detail */
    public static function getNewRank($rank)
    {
        $ranks = [];
        $rank_detail = Model\Rank::all()->toArray();
        foreach ($rank_detail as $key => $value) {
            $ranks[$value['id']] = $value['id'];
        }
        $curr_ind = array_search($rank, $ranks);
        $next_ind = $curr_ind + 1;
        if (Model\Rank::where('id', $ranks[$next_ind])->count() > 0)
            return Model\Rank::where('id', $ranks[$next_ind])->first();
        else
            false;
    }


    public static function check_ranking_upgrade($own_package, $direct_downline, $direct_downline_packages, $total_downline_packages)
    {

        $ranks = Model\Rank::where('name', '!=', 'SPECIAL')->get();
        $qaulified_ranks = [];
        foreach ($ranks as $key => $value) {

            if ($own_package >= $value->own_package && $direct_downline->count() >= $value->direct_downline && $direct_downline_packages >= $value->direct_downline_packages && $total_downline_packages >= $value->total_downline_packages) {

                if ($value->rank_total_downline > 0) {
                    $validate_rank = Helper::check_downline_level_ranks($direct_downline, $value, $value->rank_total_downline, $value->rank_level);
                    if ($validate_rank) {
                        $qaulified_ranks = $value;
                    }
                } else {
                    $qaulified_ranks = $value;
                }
                if($qaulified_ranks >  0){
                    return $qaulified_ranks;
                }

            }
        }
        return $qaulified_ranks;


    }

    public static function check_downline_level_ranks($direct_downline, $rank, $count, $level)
    {
        $count_rank = 0;
        foreach ($direct_downline as $key => $downline) {
            # code...
            if (Helper::checkHigherRanking($downline->rank_id, $rank->id)) {
                $count_rank = $count_rank + 1;
            }
        }
        if ($count >= $count_rank) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUplineUser($user_detail,$level=1,$array=[]){
        

        $sponser_details = \App\User::with('rank')->where(['id'=>$user_detail->sponsor,'status'=>'active'])->first();
        // print_r($sponser_details);

        if($sponser_details==null || $user_detail->sponsor ==0 || $user_detail->id == $sponser_details->id ){
            // echo "<br>getUplineSponsor : username ".$user_detail->username;
            // echo "<br>getUplineSponsor : username ".$user_detail->sponsor_id;
            return $array;
        }else{           
            
            $sponser_details->level = $level;
            $sponser_details->direct_downline = Helper::activeDownline($sponser_details->id);
            $array[$level] = $sponser_details;  

            // $array[$level]['total_level'] = $level;  
            $level = $level + 1;
             // echo "<br>Else : username ".$sponser_details->username;
             // echo "<br>Else : username ".$sponser_details->sponsor_id;
            return Helper::getUplineUser($sponser_details,$level,$array);
            
        }
    }

    public static function getDownline($sponsor_id){
       $output = User::where(['status'=>'active','sponsor'=>$sponsor_id])->get();
       return $output->toArray();
    }

    /* Get Array of All Downline users detail */
    public static function getAllDownline($sponsor_id,$array=[]){
       $direct_downline = Helper::getDownline($sponsor_id);
       if(count($direct_downline) == 0){
           return $array;
       }else{
           // $array = array_merge($array, $direct_downline);
           // foreach ($direct_downline as $key => $value) {
           //      $array = Helper::getAllDownline($value['id'],$array);
           // }
       }
       return $array; 
    }

    /* Send user mail notification */
    public static function sendUserNotification($data=[]){
       
    	$user = User::where('id',$data['user_id'])->first();
    	if($user){
    		$value = ['content' => $data['content'], 'username' => $user->user_name];
    		\Mail::send('emails.general_mail_template', $value, function ($message) use ($user, $data) {
    			$message->subject($data['content']);
    			$message->to($user->email);
    		});

    		$response['status'] = 'Success';
    	}
    	$response['status'] = 'Failed';
       return $response;
    }

    /* Send admin mail notification */
    public static function sendAdminNotification($data=[]){
       
    	if($data){
    		$user = User::where('id',$data['user_id'])->first();
    		if($user){

    			$content = str_replace('{{USERNAME}}', $user->user_name, $data['content']);
    			$value = ['content' => $content, 'username' => 'Admin'];

    			\Mail::send('emails.general_admin_mail_template', $value, function ($message) use ($data) {
    				$message->subject($data['subject']);
                    // $message->to('ankita.vyas@aipxperts.com');   
                    $message->to('contact@avanya.net');
    			});

    			$response['status'] = 'Success';
    		}
    	}
    	$response['status'] = 'Failed';
        return $response;
    }

}
