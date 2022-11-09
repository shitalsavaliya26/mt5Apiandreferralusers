<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer(['*'], function ($view) {
            if (Auth::guard('admin')->check()) {
                // \DB::enableQueryLog();
                $supportUnreadCount = \App\Models\TicketMessage::where('reply_from','user')->whereHas('support')->where('is_read','0')->distinct('support_id')->count();
                // dd(\DB::getQueryLog());
                $supportTicket = \App\Models\TicketMessage::with(['support'=>function($q1){ return  $q1->with('titles'); }])->where('reply_from','user')->whereHas('support')->whereHas('user')->where('is_read','0')->distinct('support_id')->orderBy('id','desc')->take(5)->get();
                // echo $supportUnreadCount;
                // dd($supportTicket->first());
                view()->share('supportUnreadCount',$supportUnreadCount);
                view()->share('supportTicket',$supportTicket);
            }
            if (Auth::guard('web')->check()) {

                $previousFunding = \App\Models\TopupFund::where(['user_id'=>auth()->id(),'status'=>'1'])->count();

                $supportUnreadCount = \App\Models\TicketMessage::whereHas('support', function($query){
                    $query->where('user_id',auth()->id());
                })->where('reply_from','admin')->where('is_read','0')->distinct('support_id')->count();

                $supportTicket = \App\Models\TicketMessage::whereHas('support', function($query){
                    $query->where('user_id',auth()->id());
                })->where('reply_from','admin')->where('is_read','0')->distinct('support_id')->orderBy('id','desc')->take(5)->get();
                view()->share('previousFunding',$previousFunding);
                view()->share('supportTicket',$supportTicket);
                view()->share('supportUnreadCount',$supportUnreadCount);
            }
        });

    }
}
