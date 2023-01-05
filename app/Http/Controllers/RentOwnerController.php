<?php

namespace App\Http\Controllers;

use App\Models\RentOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RentOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = RentOwner::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();

        if($rents->count() > 0){
            return response()->json([
                'status' => 200,
                'data' => $rents
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
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        
        if ($request->hasFile('agreement_image')) {
            $image = $request->file('agreement_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/agreement/'), $filename);
            $data['agreement_image'] = $filename;
            
            // the rest of your code
         }

         if ($request->hasFile('pan_image')) {
            $image = $request->file('pan_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/pan/'), $filename);
            $data['pan_image'] = $filename;
            
            // the rest of your code
         }

         if ($request->hasFile('bill_pdf')) {
            $image = $request->file('bill_pdf');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/bill/'), $filename);
            $data['bill_pdf'] = $filename;
            
            // the rest of your code
         }

         RentOwner::create($data);

         return response()->json([
            'message' => 'Rent added succssfully',
            'status' => 200,
            'data' => $data
         ]);
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentOwner  $rentOwner
     * @return \Illuminate\Http\Response
     */
    public function show(RentOwner $rentOwner)
    {
        if($rentOwner){
            return response()->json([
                'status' => 200,
                'data' => $rentOwner
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
     * @param  \App\Models\RentOwner  $rentOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentOwner $rentOwner)
    {
        $data = $request->all();
        
        $data['user_id'] = Auth::user()->id;

       // return $rentOwner->agreement_image;
        
        if ($request->hasFile('agreement_image')) {

            $filePath = public_path('assets/rent/agreement/').'/'.$rentOwner->agreement_image;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('agreement_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/agreement/'), $filename);
            $data['agreement_image'] = $filename;
            
            // the rest of your code
         }else{
            $data['agreement_image'] = $rentOwner->agreement_image;
         }

         if ($request->hasFile('pan_image')) {
            $filePath = public_path('assets/rent/pan/').'/'.$rentOwner->pan_image;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('pan_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/pan/'), $filename);
            $data['pan_image'] = $filename;
            
            // the rest of your code
         }
         else{
            $data['pan_image'] = $rentOwner->pan_image;
         }

         if ($request->hasFile('bill_pdf' && $rentOwner->bill_pdf != null)) {
            $filePath = public_path('assets/rent/bill/').'/'.$rentOwner->bill_pdf;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('bill_pdf');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/bill/'), $filename);
            $data['bill_pdf'] = $filename;
            
            // the rest of your code
         }else{
            $data['bill_pdf'] = $rentOwner->bill_pdf;
         }

        $rentOwner->fill($data);
        $rentOwner->save();

         return response()->json([
            'message' => 'Rent updated succssfully',
            'status' => 200,
            'data' => $rentOwner
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RentOwner  $rentOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentOwner $rentOwner)
    {
        if($rentOwner){
            $filePath_agreement = public_path('assets/rent/agreement/').'/'.$rentOwner->agreement_image;
            if ( $filePath_agreement){
                File::delete( $filePath_agreement);
            }
            $filePath_pan = public_path('assets/rent/pan/').'/'.$rentOwner->pan_image;
            if ( $filePath_pan){
                File::delete( $filePath_pan);
            }
            $filePath_bill = public_path('assets/rent/bill/').'/'.$rentOwner->bill_pdf;
            if ( $filePath_bill){
                File::delete( $filePath_bill);
            }
            $rentOwner->delete();
            return response()->json([
                'status' => 200,
                'data' => $rentOwner,
                'message' => 'Rentowner deleted succesfully'
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => 'no data to delete'
            ]);
        }
    }
}
