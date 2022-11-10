<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashbook extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d',
    // ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
