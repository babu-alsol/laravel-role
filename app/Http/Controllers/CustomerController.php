<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Auth::user()->customers()->get();

        if ($customers->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $customers
            ]);
        }else{
            return response()->json([
                'status' => 'No Customers to show',
                //'data' => $students
            ]);
        }
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'cus_name' => 'required',
           // 'cus_address' => 'required',
            'cus_mobile' => 'required|min:8|max:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:customers',
            
            'customer_type' => 'required'
        ]);

        //return $request->all();

        $customer = new Customer();

        $customer->cus_name = $request->cus_name;
        $customer->cus_address = $request->cus_address;
        $customer->cus_mobile = $request->cus_mobile;
        $customer->customer_type = $request->customer_type;

        $customer->save();

        $customer->users()->attach(Auth::user()->id);

        return response()->json([
            'status' => 200,
            'message' => 'Customer Created Succesffuly',
            'data' => $customer
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'status' => 'okay',
            
            'data' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'cus_name' => 'required',
           // 'cus_address' => 'required',
            'cus_mobile' => 'required',
            
            'customer_type' => 'required'
        ]);

       // return $request->all();

        $customer->cus_name = $request->cus_name;
        $customer->cus_address = $request->cus_address;
        $customer->cus_mobile = $request->cus_mobile;
        $customer->customer_type = $request->customer_type;

        $customer->save();

        $customer->users()->sync(Auth::user()->id);

        return response()->json([
            'status' => 'okay',
            'message' => 'Customer updated Succesffuly',
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $customer->users()->detach();

        return response()->json([
            'status' => 'okay',
            'message' => 'Customer deleted Succesffuly',
            'data' => $customer
        ]);
    }
}
