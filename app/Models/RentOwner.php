<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentOwner extends Model
{
    use HasFactory;

    use SoftDeletes;

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
