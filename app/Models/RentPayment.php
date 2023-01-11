<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rentOwner(){
        return $this->belongsTo(RentOwner::class, 'rent_id');
    }  
}
