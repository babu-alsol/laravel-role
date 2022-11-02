<?php

namespace App\Http\Controllers;

use App\Models\BankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_banks = BankDetails::all();

        if ($customer_banks->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $customer_banks
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
        $data['bns_id'] = Auth::user()->id;

        BankDetails::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Bank added Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankDetails  $bankDetails
     * @return \Illuminate\Http\Response
     */
    public function show(BankDetails $bankDetails)
    {
        if ($bankDetails){
            return response()->json([
                'status' => 200,
                'data' => $bankDetails
            ]); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'not found'
            ]); 
        }
       
    }

  
    public function update(Request $request, BankDetails $bankDetails)
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

        $bankDetails->fill($data);
        $bankDetails->save();

        return response()->json([
            'status' => 200,
            'message' => 'Bank updated Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankDetails  $bankDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankDetails $bankDetails)
    {
        if ($bankDetails){
            $bankDetails->delete();
            return response()->json([
                'status' => 200,
                'data' => $bankDetails,
                'message' => 'bank deleted successfuly'
            ]); 
        }
        return response()->json([
            'status' => 404,
            'message' => 'not found'
        ]); 
    }
}
