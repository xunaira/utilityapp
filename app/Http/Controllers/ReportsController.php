<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Exports\AgentSales;
use App\Exports\SalesExport;
use App\Exports\WalletExport;
use Excel;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function sales(){
    	//add balance and sales 
    	$transactions = DB::table('transactions')
                        ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                        ->join('add_sales', 'transactions.sales_id', '=', 'add_sales.id')
                        ->join('products', 'add_sales.product_id', '=', 'products.id')
                        ->join('users', 'add_sales.agent', '=','users.agent_id')
                        ->select('products.product_name', 'add_sales.sale_value', 'wallet.total_funds', 'transactions.closing_balance', 'transactions.date', 'users.name')
                        ->paginate(15);
        return view('reports.sales', ['transactions' => $transactions]);

    }

    public function salesexport(){
    	$transactions = DB::table('transactions')
                        ->join('wallet', 'transactions.wallet_id', '=', 'wallet.id')
                        ->join('add_sales', 'transactions.sales_id', '=', 'add_sales.id')
                        ->join('products', 'add_sales.product_id', '=', 'products.id')
                        ->join('users', 'add_sales.agent', '=','users.agent_id')
                        ->select('users.name','products.product_name', 'add_sales.sale_value', 'wallet.total_funds', 'transactions.closing_balance', 'transactions.date')
                        ->get();
    	
        $file_name = "Sales.xlsx";  
        
        
       return Excel::download(new SalesExport($transactions), $file_name);
    }

    public function wallet(){
    	$wallet = DB::table('wallet')
    				->join('users', 'users.agent_id', '=', 'wallet.user_id')
                    ->join('balance', 'users.company_id', '=', 'balance.company_id')
    				->select('users.name', 'wallet.cash_in_hand', 'wallet.cash_bank', 'wallet.total_funds', 'wallet.date', 'balance.cash_bank as bal_cash', 'balance.cash_hand as bal_hand')
    				->get();
    				
    	return view('reports.wallet', ['wallet' => $wallet]);
    	
    }

    public function walletexport(){
    	$wallet = DB::table('wallet')
    				->join('users', 'users.agent_id', '=', 'wallet.user_id')
    				->select('users.name', 'wallet.cash_in_hand', 'wallet.cash_bank', 'wallet.total_funds', 'wallet.date')
    				->get();

    	$file_name = "Wallet.xlsx";  
        
        
       return Excel::download(new WalletExport($wallet), $file_name);
    }

    public function agents(){
    	//get all agents 
    	if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.*','agents.*', 'supervisor.name as sup')
            ->where('supervisor_id', Auth::user()->id)
            ->get();
        }

        return view('reports.agents', ['agents' => $agents]);
    	
    }

    public function agentexport(){
    	if(Auth::user()->role_id == 1){
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.name','users.email','agents.address1', 'agents.address2', 'agents.city', 'agents.state', 'agents.country', 'agents.phone_no', 'agents.operational_area', 'agents.salary', 'supervisor.name as sup', 'agents.agent_type', 'agents.commission')
            ->get();
        }else{
            $agents = DB::table('agents')
            ->join('supervisor', 'supervisor.user_id', '=', 'agents.supervisor_id')
            ->join('users', 'agents.id', '=', 'users.agent_id')
            ->select('users.name','users.email','agents.address1', 'agents.address2', 'agents.city', 'agents.state', 'agents.country', 'agents.phone_no', 'agents.operational_area', 'agents.salary', 'supervisor.name as sup', 'agents.agent_type', 'agents.commission')
            ->where('supervisor_id', Auth::user()->id)
            ->get();
        }

        $file_name = "Agents.xlsx";  
        
        
       return Excel::download(new AgentSales($agents), $file_name);
    }
}
