<?php

namespace App\Http\Controllers;

use App\Models\RentOwner;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rent_payments = RentPayment::with('rentOwner')->orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();
    
        if($rent_payments->count() > 0){
            return response()->json([
                'status' => 200,
                'data' => $rent_payments
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => 'no data to show'
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rent_date' => 'required',
            'rent_amount' => 'required'
        ]);


        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        RentPayment::create($data);

        return response()->json([
            'message' => 'RentPayment added successfully',
            'status' => 200,
            'data' => $data,
           
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function show(RentPayment $rentPayment)
    {
        if($rentPayment){
            return response()->json([
                'status' => 200,
                'data' => $rentPayment,
                'rent_owner' => $rentPayment->rentOwner
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => 'no data to show'
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentPayment $rentPayment)
    {

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $rentPayment->fill($data);
        $rentPayment->save();

        return response()->json([
            'message' => 'RentPayment updated successfully',
            'status' => 200,
            'data' => $rentPayment,
            'rent_owner' => $rentPayment->rentOwner
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentPayment $rentPayment)
    {
        if($rentPayment){
            $rentPayment->delete();
            return response()->json([
                'status' => 200,
                'data' => $rentPayment,
                'message' => 'Rentpayment deleted succesfully'
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => 'no data to delete'
            ]);
        }
    }
}
