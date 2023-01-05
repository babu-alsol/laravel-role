<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentOwner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rentPayments(){
        return $this->hasMany(RentPayment::class, 'rent_id');
    }

    public function monthlyPayments(){
        return $this->hasMany(MonthlyPayment::class, 'rent_id');
    }
}
