<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {

        $transanctions = Transaction::where('user_id', Auth::user()->id)->where('cus_type', $type)->get();
        //return $transanctions;

        if ($transanctions->count() > 0) {
            return response()->json([
                'status' => 'Ok',
                'data' => $transanctions
            ]);
        } else {
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
            'customer_id' => 'required',
            'attachment' => 'mimes:doc,docx,pdf,txt,csv,jpg,png,xlsx|max:10800',
            'date_time' => 'required',
            'payment_details' => 'required'

        ]);

        //return $request->all();

        $customer = Customer::where('id', $request->customer_id)->first();




        $data = $request->all();
        $data['cus_type'] = $customer->customer_type;
        $data['cus_name'] = $customer->cus_name;
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill' . rand(10000000, 99999999);
        $data['tns_gateway_id'] = 'TNSGET' . rand(10000000, 99999999);

        if ($request->file()) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('uploads/transaction/attachments', $fileName, 'public');
            //$data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
            $data['attachment'] = '/storage/' . $filePath;
        }

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
        if ($transaction) {
            return response()->json([
                'status' => 200,

                'data' => $transaction
            ]);
        }
        return response()->json([
            'status' => 404,

            'message' => 'not found'
        ]);
    }


    public function update(Request $request, Transaction $transaction)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'tns_type' => 'required',
            'customer_id' => 'required',
            'attachment' => 'mimes:doc,docx,pdf,txt,csv,jpg,png,xlsx|max:10800',
            'date_time' => 'required',
            'payment_details' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill' . rand(10000000, 99999999);
        $data['tns_gateway_id'] = 'TNSGET' . rand(10000000, 99999999);


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
        if ($transaction) {
            $transaction->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Transaction deleted',
                'data' => $transaction
            ]);
        }
        return response()->json([
            'status' => 404,

            'message' => 'not found'
        ]);
    }

    public function tnsCustomer(Customer $customer)
    {
       // return $customer;
        $transactions_give = Transaction::where('user_id', Auth::user()->id)->where('customer_id', $customer->id)->where('tns_type', 'give')->sum('amount');

        $transactions_got = Transaction::where('user_id', Auth::user()->id)->where('customer_id', $customer->id)->where('tns_type', 'got')->sum('amount');

        return response()->json([
            'customer' => $customer,
            'transactions' => $customer->transactions,
            'effective_transactions' => $transactions_got - $transactions_give
        ]);
    }

    public function tnsSupplier(Customer $customer)
    {



        $transactions_give = Transaction::where('user_id', Auth::user()->id)->where('customer_id', $customer->id)->where('tns_type', 'give')->sum('amount');

        $transactions_got = Transaction::where('user_id', Auth::user()->id)->where('customer_id', $customer->id)->where('tns_type', 'got')->sum('amount');

        return response()->json([
            'supplier' => $customer,
            'transactions' => $customer->transactions,
            'effective_transactions' => $transactions_got - $transactions_give
        ]);
    }

    public function customerTransactions()
    {
       // $customer = Customer::with('transactions')->where('user_id', 9)->first();

      //  return $customer;

        $customers = Customer::with('transactions')->where('user_id', Auth::user()->id)
        ->where('customer_type', 'customer')->get();

       // return $customers;
      // $customers = (array) $customers;

        return $customers;

        foreach ($customers as $customer){
            $customer = (object) $customer;
            return response()->json([
                'customers' => $customer,
                //'transactions' => $customer->effectivePrice
            ]);

            
            // foreach ($customer as $tns) {

            //    // $tns_give = $tns->transactions->where('tns_type', 'give')->get();

            //     //return $tns_give;
            //     return response()->json([
            //         'customers' => $customer,
            //         'transactions' => $tns->transactions
            //     ]);


            // }

           
            
            //return $customer;
        }

       // return $customers;
       
        // $customers = Customer::select(    
        //     'customers.*',
        //     'transactions.*'
        // )->leftjoin('transactions', 'customers.id', '=', 'transactions.customer_id')
        // ->where('user_id', Auth::user()->id)->where('tns_type', 'give')->sum('amount');

        // $customers_got = Customer::select(    
        //     'customers.*',
        //     'transactions.*'
        // )->leftjoin('transactions', 'customers.id', '=', 'transactions.customer_id')
        // ->where('user_id', Auth::user()->id)->where('tns_type', 'got')->sum('amount');


      //  return $customers_got - $customers_give;

        // foreach ($customers as $customer) {
        //    echo $customer;
        //     return response()->json([
        //         'customers' => $customer
        //     ]);
        // }
        //return $customers;

     
    }

    public function supplierTransactions()
    {
       // $customer = Customer::with('transactions')->where('user_id', 9)->first();

      //  return $customer;

        $customers = Customer::with('transactions')->where('user_id', Auth::user()->id)
        ->where('customer_type', 'supplier')->get();

       // return $customers;
       $customers = (array) $customers;

       // return $customers;

        foreach ($customers as $customer){
            $customer = (object) $customer;

            return $customer;
            
            //return $customer;
        }

      
     
    }
}
