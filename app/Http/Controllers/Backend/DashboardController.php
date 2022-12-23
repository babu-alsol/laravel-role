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
        $new_user = count(User::whereDate('created_at', $today)->get());
        $new_transactions = count(Transaction::whereDate('date_time', $today)->get());
        $new_cashbooks = count(Cashbook::whereDate('date_time', $today)->get());

        $total_roles = count(Role::select('id')->get());
        $total_admins = count(Admin::select('id')->get());
        $total_permissions = count(Permission::select('id')->get());
        $all_transactions = count(Transaction::all());
        $all_cashbooks = count(Cashbook::all());
        $all_users = count(User::all());
        return view('backend.pages.dashboard.index', compact('total_admins',
         'total_roles', 'total_permissions','all_transactions', 'all_cashbooks',
          'all_users', 'new_user', 'new_transactions', 'new_cashbooks', 'online_transactions'));
    }
}
