<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = Rent::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();

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

         Rent::create($data);

         return response()->json([
            'message' => 'Rent added succssfully',
            'status' => 200,
            'data' => $data
         ]);
         


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        if($rent){
            return response()->json([
                'status' => 200,
                'data' => $rent
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
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
       

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        
        if ($request->hasFile('agreement_image' && $rent->agreement_image != null)) {

            $filePath = public_path('assets/rent/agreement/').'/'.$rent->agreement_image;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('agreement_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/agreement/'), $filename);
            $data['agreement_image'] = $filename;
            
            // the rest of your code
         }

         if ($request->hasFile('pan_image' && $rent->pan_image != null)) {
            $filePath = public_path('assets/rent/pan/').'/'.$rent->pan_image;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('pan_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/pan/'), $filename);
            $data['pan_image'] = $filename;
            
            // the rest of your code
         }

        $rent->fill($data);

         return response()->json([
            'message' => 'Rent updated succssfully',
            'status' => 200,
            'data' => $data
         ]);
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
