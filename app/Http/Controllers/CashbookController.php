<?php

namespace App\Http\Controllers;

use App\Models\Cashbook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashbooks = Cashbook::where('user_id', Auth::user()->id);

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
        // $request->validate([
        //     'amount' => 'required',
        //     'cb_tns_type' => 'required',
        //     'payment_type' => 'required',
        //     'attachments' => 'mimes:doc,docx,pdf,txt,csv|max:2048',
            
        // ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['amount'] = $request->amount;
        

        
        $file = $request->file('attachments');
        return $data;
            $name = $file->getClientOriginalName();
            $path = $file->store('public/cashbook/attachments', $name);
            
  
            //store your file into directory and db
        
        $data['atachments'] = $path;

        return $data;


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
        $todays_cashbooks = Cashbook::where('created_at', $today)->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }
}
