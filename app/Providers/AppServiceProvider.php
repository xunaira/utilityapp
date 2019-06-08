<?php

namespace App\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Balance;
use Auth;
use App\Reports;
use View;
use Carbon;
use App\Transactions;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //
        Schema::defaultStringLength(191);

        View::composer('*', function ($view)
        {
           
            if(Auth::user()){
                if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
                    $b = Balance::balance();
                    $view->with('bal', $b);
                }else{
                    $w = Transactions::wallet_money();
                    $view->with('bal', $w);
                }
                
            }else{
                return view('auth.login');
            }
           
        });
    }
}
