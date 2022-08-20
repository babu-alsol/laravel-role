<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transanctions = Transaction::where('customer_id', Auth::user()->id);

        if ($transanctions->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $transanctions
            ]);
        }else{
            return response()->json([
                'status' => 'No Transactions to show',
                //'data' => $students
            ]);
        }
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'amount' => 'required|numeric',
            'tns_type' => 'required',
            'customer_id' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill'.rand(10000000,99999999);
        $data['tns_gateway_id'] = 'TNSGET'.rand(10000000,99999999);

        Transaction::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Transaction done',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if ($transaction){
            return response()->json([
                'status' => 200,
               
                'data' => $transaction
            ]);
        } return response()->json([
            'status' => 404,
            
            'message' => 'not found'
        ]);
       
    }

   
    public function update(Request $request, Transaction $transaction)
    {
           
        $request->validate([
            'amount' => 'required|numeric',
            'customer_id' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill'.rand(10000000,99999999);
        $data['tns_gateway_id'] = 'TNSGET'.rand(10000000,99999999);


        $transaction->fill($data);
        $transaction->save();

        return response()->json([
            'status' => 200,
            'message' => 'Transaction Updated',
            'data' => $data
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction){
            $transaction->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Transaction deleted',
                'data' => $transaction
            ]);
        } return response()->json([
            'status' => 404,
            
            'message' => 'not found'
        ]);
       
    }
}
