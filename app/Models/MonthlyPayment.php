<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'monthly_payment_bifurcations';

    public function rentOwner(){
        return $this->belongsTo(RentOwner::class, 'rent_id');
    }
}
