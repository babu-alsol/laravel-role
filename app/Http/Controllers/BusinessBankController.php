<?php

namespace App\Http\Controllers;

use App\Models\BusinessBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_banks = BusinessBank::all();

        if ($business_banks->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $business_banks
            ]);
        }else{
            return response()->json([
                'status' => 'No Banks to show',
                //'data' => $students
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'upi_id' => 'required',
            'account_no' => 'required',
            'ifsc' => 'required',
        ]);

        $data = $request->all();
        $data['customer_id'] = Auth::user()->id;

        BusinessBank::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Bank added Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessBank  $businessBank
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessBank $businessBank)
    {
        if ($businessBank){
            return response()->json([
                'status' => 200,
                'data' => $businessBank
            ]); 
        }
        return response()->json([
            'status' => 404,
            'message' => 'not found'
        ]); 
    }

   
    public function update(Request $request, BusinessBank $businessBank)
    {
        $request->validate([
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'upi_id' => 'required',
            'account_no' => 'required',
            'ifsc' => 'required',
        ]);

        $data = $request->all();
        $data['customer_id'] = Auth::user()->id;

        $businessBank->fill($data);
        $businessBank->save();

        return response()->json([
            'status' => 200,
            'message' => 'Bank updated Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessBank  $businessBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessBank $businessBank)
    {
        if ($businessBank){
            $businessBank->delete();
            return response()->json([
                'status' => 200,
                'data' => $businessBank,
                'message' => 'bank deleted successfuly'
            ]); 
        }
        return response()->json([
            'status' => 404,
            'message' => 'not found'
        ]); 
    }
}
