<?php

namespace App\Http\Controllers;

use App\Models\Cashbook;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDF;

class CashbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($start_date = null, $end_date = null)
    {

        $today = Carbon::today();
        // return $today;

        if ($start_date == null && $end_date == null) {
            $cashbooks = Cashbook::where('user_id', Auth::user()->id)->orderBy('date_time', 'desc')->whereDate('date_time', $today)->get();
        } else {
            $cashbooks = Cashbook::where('user_id', Auth::user()->id)->orderBy('date_time', 'desc')->whereBetween('date_time', [$start_date, $end_date])->get();
        }


        if ($cashbooks->count() > 0) {
            return response()->json([
                'status' => 'Ok',
                'data' => $cashbooks
            ]);
        } else {
            return response()->json([
                'status' => 'No Cashbook entry to show',
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
            'message' => 'Cashbook creted Succesfully',
            'data' => $data,
            
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
            'amount' => 'required',
            'cb_tns_type' => 'required',
            'payment_type' => 'required',
            'attachments' => 'mimes:doc,docx,pdf,txt,csv,jpg,png|max:2048',
           // 'payment_details' => 'required',
            //'date_time' => 'required'

        ]);

        $data = $request->all();

        if ($request->date_time) {
            $data['date_time'] = $request->date_time;
        } else {
            $data['date_time'] = Carbon::now();
        }

        $data['user_id'] = Auth::user()->id;


        if ($request->hasFile('attachments') && $cashbook->attachments != null) {

            $filePath = public_path('assets/cashbook/attachments/').'/'.$cashbook->attachments;
            if ($filePath){
                File::delete($filePath);
            }
            $image = $request->file('attachments');
            $filename = now()->timestamp . '.' . $image->getClientOriginalExtension();
        
            $image->move(public_path('assets/cashbook/attachments/'), $filename);
            $data['attachments'] = public_path('assets/cashbook/attachments/').'/'.$filename;
            
            // the rest of your code
         }

      
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
        if ($cashbook) {
            $cashbook->delete();
            return response()->json([
                'status' => 200,
                'data' => $cashbook
            ]);
        }
    }

    public function todayCashbook()
    {
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }

    public function weekCashbook()
    {
        $week = Carbon::today()->subDays(7);
        //return $today;
        $weeks_cashbooks = Cashbook::whereDate('created_at', $week)->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 200,
            'data' => $weeks_cashbooks
        ]);
    }

    public function monthCashbook()
    {
        $month = Carbon::today()->subDays(30);
        //return $today;
        $months_cashbooks = Cashbook::whereDate('created_at', $month)->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 200,
            'data' => $months_cashbooks
        ]);
    }

    public function todayCashbookIn()
    {
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->where('cb_tns_type', 'in')->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }

    public function todayCashbookOut()
    {
        $today = Carbon::today();
        //return $today;
        $todays_cashbooks = Cashbook::whereDate('created_at', $today)->where('cb_tns_type', 'out')->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 200,
            'data' => $todays_cashbooks
        ]);
    }


    public function createPdf($start_date = null, $end_date = null,)
    {


       
        // return $today;


        if ($start_date == null && $end_date == null) {
            $cashbooks = Cashbook::where('user_id', Auth::user()->id)->orderBy('date_time', 'desc')->get();
        } else {
            $cashbooks = Cashbook::where('user_id', Auth::user()->id)->orderBy('date_time', 'desc')->whereBetween('date_time', [$start_date, $end_date])->get();
        }
       // return $cashbooks;

        //return $months_cashbooks;

        $pdf = PDF::loadView('cashbook', compact('cashbooks'));

        $filename = 'cashbook' . '-' . time() . '.pdf';

        $path = str_replace('\\', '/', public_path("assets/cashbook/report/" . $filename));


        //return $pdf;
        //return $pdf->download('pdf_file.pdf');
        $pdf->save($path);

        return response()->json([
            'message' => 'Pdf generated',
            'path' => $filename
        ]);

        // download PDF file with download method
        //return $pdf->download('pdf_file.pdf');
    }

    public function viewReports()
    {
        //return Auth::user()->id;

        $today = Carbon::today();

        $cash_in_hands_in = Cashbook::where('cb_tns_type', 'in')->where('user_id', Auth::user()->id)->where('payment_type', 'cash')->sum('amount');

        $cash_in_hands_out = Cashbook::where('cb_tns_type', 'out')->where('user_id', Auth::user()->id)->where('payment_type', 'cash')->sum('amount');

        $today_income_in = Cashbook::where('user_id', Auth::user()->id)->whereDate('created_at', $today)->where('cb_tns_type', 'in')->sum('amount');

        $today_income_out = Cashbook::where('user_id', Auth::user()->id)->whereDate('created_at', $today)->where('cb_tns_type', 'out')->sum('amount');

        $to_collect = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'give')->sum('amount');

        $to_pay = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'got')->sum('amount');



        return response()->json([
            'cash_in_hands' => $cash_in_hands_in - $cash_in_hands_out,
            'todays_income' => $today_income_in - $today_income_out,
            'cash_in' => $today_income_in,
            'cash_out' => $today_income_out,
            'to_collect' => $to_collect,
            'to_pay' => $to_pay
        ]);
    }

    public function viewReportsType($type)
    {
        //return Auth::user()->id;

        $today = Carbon::today();

        $cash_in_hands_in = Cashbook::where('cb_tns_type', 'in')->where('user_id', Auth::user()->id)->where('payment_type', 'cash')->sum('amount');

        $cash_in_hands_out = Cashbook::where('cb_tns_type', 'out')->where('user_id', Auth::user()->id)->where('payment_type', 'cash')->sum('amount');

        $today_income_in = Cashbook::where('user_id', Auth::user()->id)->whereDate('created_at', $today)->where('cb_tns_type', 'in')->sum('amount');

        $today_income_out = Cashbook::where('user_id', Auth::user()->id)->whereDate('created_at', $today)->where('cb_tns_type', 'out')->sum('amount');

        $to_collect = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'give')->where('cus_type', $type)->sum('amount');

        $to_pay = Transaction::where('user_id', Auth::user()->id)->where('tns_type', 'got')->where('cus_type', $type)->sum('amount');



        return response()->json([
            'cash_in_hands' => $cash_in_hands_in - $cash_in_hands_out,
            'todays_income' => $today_income_in - $today_income_out,
            'cash_in' => $today_income_in,
            'cash_out' => $today_income_out,
            'to_collect' => $to_collect,
            'to_pay' => $to_pay
        ]);
    }
}
