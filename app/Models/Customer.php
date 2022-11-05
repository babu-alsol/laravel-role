<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
