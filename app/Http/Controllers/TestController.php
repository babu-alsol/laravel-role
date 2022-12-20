<?php

namespace App\Http\Controllers;

use App\Models\Cashbook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'cb_tns_type' => 'required',
            'payment_type' => 'required',
            'attachments' => 'mimes:doc,docx,pdf,txt,csv,jpg,png,xlsx|max:2048'
            // 'date_time' => 'required'

        ]);

        $data = $request->all();

        // return $data;
        if ($request->date_time) {
            $data['date_time'] = $request->date_time;
        } else {
            $data['date_time'] = Carbon::now();
        }

        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['amount'] = $request->amount;


        if ($request->hasFile('attachments')) {
            $image = $request->file('attachments');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/cashbook/attachments/'), $filename);
            $data['attachments'] = $filename;
            
            // the rest of your code
         }
        // if ($request->file()) {
        //     $fileName = time() . '_' . $request->file('attachments')->getClientOriginalName();
        //     $filePath = $request->file('attachments')->storeAs('uploads/cashbook/attachments', $fileName, 'public');
        //     //$data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
        //     $data['attachments'] = '/storage/' . $filePath;
        // }
        //store your file into directory and db



        //return $data;


        Cashbook::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Cashbook creted Succesffuly',
            'data' => $data,
            
        ]);
    }
}
