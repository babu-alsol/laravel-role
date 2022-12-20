<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            'payment_type' => 'required',
            'customer_id' => 'required',
            'attachment' => 'mimes:doc,docx,pdf,txt,csv,jpg,png,xlsx|max:10800',
           // 'date_time' => 'required',

        ]);

        $data = $request->all();
        //return $request->all();

        $customer = Customer::where('id', $request->customer_id)->first();

        if ($request->date_time) {
            $data['date_time'] = $request->date_time;
        } else {
            $data['date_time'] = Carbon::now();
        }


       
        $data['cus_type'] = $customer->customer_type;
        $data['cus_name'] = $customer->cus_name;
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill' . rand(10000000, 99999999);
        $data['tns_gateway_id'] = 'TNSGET' . rand(10000000, 99999999);

        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/transaction/attachments/'), $filename);
            $data['attachment'] = $filename;
            
            // the rest of your code
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
            'payment_type' => 'required',
            'customer_id' => 'required',
            'attachment' => 'mimes:doc,docx,pdf,txt,csv,jpg,png,xlsx|max:10800',
            'date_time' => 'required',
            //'payment_details' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['bill_no'] = 'Bill' . rand(10000000, 99999999);
        $data['tns_gateway_id'] = 'TNSGET' . rand(10000000, 99999999);
        if ($request->hasFile('attachment') && $transaction->attachment != null) {
            $filePath = public_path('assets/transaction/attachments/').'/'.$transaction->attachments;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('attachment');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/transaction/attachments/'), $filename);
            $data['attachment'] = public_path('assets/transaction/attachments/').'/'.$filename;
         }
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

        // $customers = Customer::with('transactions')->get();

        // $customers = Customer::Join('transactions','transactions.customer_id','customers.id')
        // ->where('transactions.user_id', Auth::user()->id)
        // ->get();


        $customers= DB::Select("SELECT 
        c.cus_name,
        c.id,
        DATEDIFF(CURDATE(),max(t.created_at)) as last_transaction_duration,
        max(t.created_at) as last_transaction_date,
        sum(amount*(case 
            when tns_type='give' THEN 1
            when tns_type='got'  THEN -1
        end)) aggsum
        FROM `transactions` t JOIN 
        customers c
        on 
        t.customer_id = c.id
        where 
        t.user_id=".Auth::user()->id."
        and 
        c.customer_type='customer'
        group by c.id,c.cus_name
        order by max(t.created_at) DESC"
        );

        // name, last transaction date, agg sum
        
        // ->where('user_id', Auth::user()->id)
        // ->where('customer_type', 'customer')->get();

        return $customers;

        // foreach ($customers as $customer){
        //     $customer = (object) $customer;
        //     return response()->json([
        //         'customers' => $customer
        //     ]);

        // }
     
    }

    public function supplierTransactions()
    {
       // $customer = Customer::with('transactions')->where('user_id', 9)->first();

      //  return $customer;


      $suppliers= DB::Select("SELECT 
      c.cus_name,
      c.id,
      DATEDIFF(CURDATE(),max(t.created_at)) as last_transaction_duration,
      max(t.created_at) as last_transaction_date,
      sum(amount*(case 
          when tns_type='advance' THEN 1
          when tns_type='purchase'  THEN -1
      end)) aggsum
      FROM `transactions` t JOIN 
      customers c
      on 
      t.customer_id = c.id
      where 
      t.user_id=".Auth::user()->id."
      and 
      c.customer_type='supplier'
      group by c.id,c.cus_name
      order by max(t.created_at) DESC"
      );


       return $suppliers;
 
     
    }
}
