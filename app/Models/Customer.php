<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class, 'customer_user');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    // public function effective(){
    //     // $transaction_give = Transaction::where('tns_type', 'give')->sum('amount');
    //     // return $transaction_give;
    // }

    public function effectivePrice(){
        // return $customer;
        $transactions_give = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'give')->sum('amount');

        $transactions_got = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'got')->sum('amount');

        return response()->json([
            
            'effective_transactions' => $transactions_got - $transactions_give
        ]);
   }
}
