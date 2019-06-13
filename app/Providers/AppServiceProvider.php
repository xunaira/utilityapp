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
use App\Admin;
use App\Supervisor;
use App\agents_migration;


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
                if(Auth::user()->role_id == 1){
                    $b = Balance::balance();
                    $pic = Admin::where('user_id', Auth::user()->id)->select('pic')->first();

                    $view->with('bal', $b)->with('pic', $pic);
                }elseif(Auth::user()->role_id == 2){
                    $b = Balance::balance();
                    $pic = Supervisor::where('user_id', Auth::user()->id)->select('pic')->first();
                    $view->with('bal', $b)->with('pic', $pic);
                }
                elseif(Auth::user()->role_id == 3){
                    $w = Transactions::wallet_money();
                    $pic = agents_migration::where('user_id', Auth::user()->id)->select('pic')->first();
                    $view->with('bal', $w)->with('pic', $pic);
                }
                
            }else{
                return view('auth.login');
            }
           
        });
    }
}
