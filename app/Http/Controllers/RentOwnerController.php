<?php

namespace App\Http\Controllers;

use App\Models\RentOwner;
use App\Models\MonthlyPayment;
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


        // dd($request->hasFile('pan_image'));
        // dd($request->hasFile('pan_image'));


        $rentOwner = new RentOwner();
        $rentOwner->user_id = Auth::user()->id;
        $rentOwner->name = $request->name;
        $rentOwner->address = $request->address;
        $rentOwner->rent_date = $request->rent_date;
        $rentOwner->deposit_amount = $request->deposit_amount;
        $rentOwner->advanced_amount = $request->advanced_amount;
        $rentOwner->pan_no = $request->pan_no;
        $rentOwner->mobile = $request->mobile;
        $rentOwner->rent_since = $request->rent_since;
        $rentOwner->account_no = $request->account_no;
        $rentOwner->bank_name = $request->bank_name;
        $rentOwner->branch_name = $request->branch_name;
        $rentOwner->ifsc_code = $request->ifsc_code;
        $rentOwner->rent_type = $request->rent_type;
        $rentOwner->account_holder_name = $request->account_holder_name;


        
        if ($request->hasFile('agreement_image')) {
            $image = $request->file('agreement_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/agreement/'), $filename);
            $rentOwner->agreement_image = $filename;
            
            // the rest of your code
         }

         if ($request->hasFile('pan_image')) {
            $image = $request->file('pan_image');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/rent/pan/'), $filename);
            $rentOwner->pan_image= $filename;
            
            // the rest of your code
         }

         if ($request->hasFile('bill_pdf')) {
            $image = $request->file('bill_pdf');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/rent/bill/'), $filename);
            $rentOwner->bill_pdf = $filename;
         }

         $rentOwner->save();

         if(isset($rentOwner)){
            $month_bifur=json_decode($request->month_bifurcation,true);
            foreach($month_bifur as $mb){
    
                $month_pay=new MonthlyPayment();
                $month_pay->amount = $mb["amount"];
                $month_pay->description = $mb["description"];
                $month_pay->rent_id = $rentOwner->id;
                $month_pay->save();
    
                }
            }

            

         return response()->json([
            'message' => 'Rent added succssfully',
            'status' => 200,
            'data' => $rentOwner,
            'bifurcations' => $month_bifur
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
                'data' => $rentOwner,
                'bifurcation' => $rentOwner->monthlyPayments
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => 'no data to show',
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

        if(isset($rentOwner)){
            // $month_bifur=json_decode($request->month_bifurcation,true);
            // foreach($month_bifur as $mb){
    
            //     $month_pay=new MonthlyPayment();
            //     $month_pay->amount = $mb["amount"];
            //     $month_pay->description = $mb["description"];
            //     $month_pay->rent_id = $rentOwner->id;
            //     $month_pay->save();
    
            //     }
            // }

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
