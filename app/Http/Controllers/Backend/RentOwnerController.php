<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RentOwner;
use Illuminate\Http\Request;

class RentOwnerController extends Controller
{
    public function index(){
        $rent_owners = RentOwner::orderBy('created_at', 'desc')->get();
        return view('backend.pages.rent_owners.index', compact('rent_owners'));
    }

    public function show(RentOwner $rentOwner){
        return view('backend.pages.rent_owners.show', compact('rentOwner'));
    }
}
