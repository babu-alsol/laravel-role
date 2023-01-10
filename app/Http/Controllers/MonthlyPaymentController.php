<?php

namespace App\Http\Controllers;

use App\Models\MonthlyPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monthly_payments = MonthlyPayment::with('rentOwner')->orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();
    
        if($monthly_payments->count() > 0){
            return response()->json([
                'status' => 200,
                'data' => $monthly_payments
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
            'amount' => 'required',
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        MonthlyPayment::create($data);

        return response()->json([
            'message' => 'MonthlyPayment added successfully',
            'status' => 200,
            'data' => $data,    
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyPayment $monthlyPayment)
    {
        if($monthlyPayment){
            return response()->json([
                'status' => 200,
                'data' => $monthlyPayment,
                'rent_owner' => $monthlyPayment->rentOwner
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
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyPayment $monthlyPayment)
    {

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $monthlyPayment->fill($data);
        $monthlyPayment->save();

        return response()->json([
            'message' => 'MonthlyPayment updated successfully',
            'status' => 200,
            'data' => $data,
            'rent_owner' => $monthlyPayment->rentOwner
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyPayment $monthlyPayment)
    {
        if($monthlyPayment){  
            $monthlyPayment->delete();  
            return response()->json([
                'status' => 200,
                'data' => $monthlyPayment,
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
