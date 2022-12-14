<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses = Business::where('user_id', Auth::user()->id)->get();

        if ($businesses->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $businesses
            ]);
        }else{
            return response()->json([
                'status' => 'No Businesses to show',
                //'data' => $students
            ]);
        }
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'bns_name' => 'required',
            'bns_type' => 'required',
            'gstin_no' => 'required',
            'bns_address' => 'required',
            //'bns_mobile' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

       
        if ($request->bns_mobile){
            $data['bns_mobile'] = $request->bns_mobile;
        }else{
            $data['bns_mobile'] = Auth::user()->mobile;
        }

        Business::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Business Created Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        if ($business){
            return response()->json([
                'status' => 200,
                
                'data' => $business
            ]);
           
        }else{
            return response()->json([
                'status' => 404,
                
                'message' => 'not found'
            ]);
        }
      
    }

  
    public function update(Request $request, Business $business)
    {
        $request->validate([
            'bns_name' => 'required',
            'bns_type' => 'required',
            'gstin_no' => 'required',
            'bns_address' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $business->fill($data);

        $business->save();

        return response()->json([
            'status' => 200,
            'message' => 'Business Updated Succesffuly',
            'data' => $data,
            'bns_id' => $business->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        if ($business){
            $business->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Business Deleted Succesffuly',
                'data' => $business
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Business Does not exist',
            
        ]);
        
    }
}
