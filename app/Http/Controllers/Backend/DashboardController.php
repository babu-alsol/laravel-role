<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cashbook;
use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $online_transactions = Transaction::where('payment_type', 'online')->sum('amount');

        //return $online_transactions;


        $today = Carbon::today();
        $thirty_days_ago = date('Y-m-d', strtotime("-31 days")); 

        $new_user = count(User::whereDate('created_at', $today)->get());

        $month_users = count(User::whereDate('created_at', ">=" , $thirty_days_ago)->get());

        $month_transactions = Transaction::whereDate('date_time', ">=" , $thirty_days_ago)->sum('amount');

        $month_cashbooks = Cashbook::whereDate('date_time', ">=" , $thirty_days_ago)->sum('amount');

        $total_online_transactions = Transaction::where('payment_type', 'online')->sum('amount');
        $month_online_transactions = Transaction::whereDate('date_time', ">=" , $thirty_days_ago)->where('payment_type', 'online')->sum('amount');
        $today_online_transactions = Transaction::whereDate('date_time', ">=" , $today)->where('payment_type', 'online')->sum('amount');

        $total_online_cashbooks = Cashbook::where('payment_type', 'online')->sum('amount');
        $month_online_cashbooks = Cashbook::whereDate('date_time', ">=" , $thirty_days_ago)->where('payment_type', 'online')->sum('amount');
        $today_online_cashbooks = Cashbook::whereDate('date_time', ">=" , $today)->where('payment_type', 'online')->sum('amount');

        //return $month_transactions;
        
        $new_transactions = Transaction::whereDate('date_time', $today)->sum('amount');

        $new_cashbooks = Cashbook::whereDate('date_time', $today)->sum('amount');

        $total_roles = count(Role::select('id')->get());

        $total_admins = count(Admin::select('id')->get());

        $total_permissions = count(Permission::select('id')->get());

        $all_transactions = Transaction::sum('amount');

        $all_cashbooks = Cashbook::sum('amount');

        $all_users = count(User::all());

        return view('backend.pages.dashboard.index', compact('total_admins',
         'total_roles', 'total_permissions','all_transactions', 'all_cashbooks',
          'all_users', 'new_user', 'new_transactions', 'new_cashbooks', 'online_transactions',
        'total_online_transactions', 'today_online_transactions', 'month_online_transactions',
        'total_online_cashbooks', 'today_online_cashbooks', 'month_online_cashbooks', 'month_transactions',
    'month_cashbooks'));
    }
}
