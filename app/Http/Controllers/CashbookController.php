<?php

namespace App\Http\Controllers;

use App\Models\Cashbook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CashbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashbooks = Cashbook::where('user_id', Auth::user()->id)->get();

        if ($cashbooks->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $cashbooks
            ]);
        }else{
            return response()->json([
                'status' => 'No Cahbook entry to show',
                //'data' => $students
            ]);
        }
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'cb_tns_type' => 'required',
            'payment_type' => 'required',
            'attachments' => 'mimes:doc,docx,pdf,txt,csv,jpg,png|max:2048',
            
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['amount'] = $request->amount;
        

        if($request->file()) {
            $fileName = time().'_'.$request->file('attachments')->getClientOriginalName();
            $filePath = $request->file('attachments')->storeAs('uploads', $fileName, 'public');
            //$data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
            $data['attachments'] = '/storage/' . $filePath;
            
        }
            //store your file into directory and db
        
       

        //return $data;


        Cashbook::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Cashbook creted Succesffuly',
            'data' => $data
        ]);
    }

   
    public function show(Cashbook $cashbook)
    {
        return response()->json([
            'status' => 200,
            'data' => $cashbook
        ]);
    }

   
    public function update(Request $request, Cashbook $cashbook)
    {
        $request->validate([
            'cb_tns_type' => 'required',
            'payment_type' => 'required',
            
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $cashbook->fill($data);

        $cashbook->save();

        return response()->json([
            'status' => 200,
            'message' => 'Cashbook updated Succesffuly',
            'data' => $cashbook
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashbook $cashbook)
    {
        if ($cashbook){
            $cashbook->delete();
            return response()->json([
                'status' => 200,
                'data' => $cashbook
            ]);
        }
    }

    public function todayCashbook(){
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }

    public function weekCashbook(){
        $week = Carbon::today()->subDays(7);
        //return $today;
        $weeks_cashbooks = Cashbook::whereDate('created_at', $week)->get();

        return response()->json([
            'status' => 200,
            'data' => $weeks_cashbooks
        ]);
    }

    public function monthCashbook(){
        $month = Carbon::today()->subDays(30);
        //return $today;
        $months_cashbooks = Cashbook::whereDate('created_at', $month)->get();

        return response()->json([
            'status' => 200,
            'data' => $months_cashbooks
        ]);
    }

    public function todayCashbookIn(){
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->where('cb_tns_type', 'in')->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }

    public function todayCashbookOut(){
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->where('cb_tns_type', 'out')->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }
    

    public function createPdf(){
        $data = Cashbook::all();
        $data = (array) $data;
        view()->share('cashbook',$data);
        $pdf = PDF::loadView('pdf_view', $data);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }
}
