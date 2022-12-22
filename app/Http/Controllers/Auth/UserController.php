<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            // 'name' => 'required|max:255',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|confirmed',
            'mobile' => 'required|min:8|max:11|regex:/^([0-9\s\-\+\(\)]*)$/'
        ]);

       // $data['password'] = bcrypt($request->password);

       $user = User::where('mobile', $request->mobile)->first();
        

       //return $user;

       if (!Auth::check()){
            if (!$user ){
                $user = new User;
                $user->mobile = $request->mobile;
                //$user->name = $request->mobile;
                $user->save();
    
                $otp = new Otp();
                $otp->mobile = $request->mobile;
                $otp->otp = rand(1000,9999);
                $otp->save();
    
               // $token = $user->createToken('API Token')->accessToken;
    
                return response()->json([
                    'message' => 'Otp send to your mobile number',
                    'status' => '200',
                    'user' => $user,
                    'otp' => $otp,
                    //'token' => $token,
                   
                ]);
            }
    
            $otp = new Otp();
            $otp->mobile = $user->mobile;
            $otp->otp = rand(1000,9999);
            $otp->save();
           // $token = $user->createToken('API Token')->accessToken;
            return response()->json([
                ['user' => $user],
                'message' => 'ph number already exist, Otp send to your mobile number ',
                'status' => '200',
               // 'token' => $token,
                'otp' => $otp
            ]);
        }
        return response()->json([
            
            'message' => 'you already login please logout ',
            'status' => '401',
            
        ]);
       
      
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            // 'email' => 'email|required',
            // 'password' => 'required'
            'mobile' => 'required|min:8|max:11|regex:/^([0-9\s\-\+\(\)]*)$/'      
        ]);

       


        $user = User::where('mobile', $request->mobile)->first();
        
        //return $user;


        
        if (!$user){
            $user = new User;
            $user->mobile = $request->mobile;
            //$user->name = $request->mobile;
            $user->save();

            $otp = new Otp();
            $otp->mobile = $request->mobile;
            $otp->otp = rand(1000,9999);
            $otp->save();

           // $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'message' => 'mobile number is not resgistered, new user created with the mobile number and Otp send to your mobile number',
                'status' => '200',
                'user' => auth()->user(),
              //  'token' => $token,
                'otp' => $otp
            ]);
        }
        //return $user->createToken('API Token')->accessToken;
        $otp = new Otp();
        $otp->mobile = $user->mobile;
        $otp->otp = rand(1000,9999);
        $otp->save();
       // $token = $user->createToken('API Token')->accessToken;
        return response()->json([
            ['user' => $user],
            'message' => 'otp send to your mobile number',
            'status' => '200',
           // 'token' => $token,
            'otp' => $otp
        ]);
        
      

       // return response(['user' => auth()->user(), 'token' => $token]);
    }

    public function logout(Request $request){
        auth()->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }

    public function sendOtp(Request $request){
       // dd($request);
       
        $request->validate([
            'mobile' => 'required',
            'name' => 'required',
            //'business_name' => 'required'
        ]);
            // $otp_rand = rand(1000, 9999);

            $otp = new Otp();
            $otp->mobile = $request->mobile;
            $otp->name = $request->name;
           // $otp->business_name = $request->business_name;
            $otp->otp = 1000;

          

            $otp->save();
           // $response = Http::get('message.neodove.com/sendsms.jsp?user=BOUNDPAR&password=7c51237a44XX&senderid=BPTOPE&mobiles=+91'.$request->mobile.'&sms=Your OTP for OnecPe app login is '.$otp_rand.'. The OTP is valid for one time.BOUNDPARIVAR .Please do not share this code with anyone for security reason.');

            return response()->json([
                'message' => 'otp send to your mobile number',
                'status' => '200',
                'name' => $request->name,
                //'otp' => $otp
            ]);

    }

    public function checkOtp(Request $request){

        $otp = Otp::where('mobile', $request->mobile)->orderBy('created_at','desc')->first();

        $request->validate([
            'otp' => 'required',
            'mobile' => 'required'
        ]);

        // return response()->json([
        //     'otp' => $otp->otp,
        //     'request' => $request->otp
          
            
        // ]);

        if ($otp->otp == $request->otp){
            $user =  $user = User::where('mobile', $request->mobile)->first();

            if (!$user){
                $user = new User;
                $user->mobile = $request->mobile;
                $user->name = $otp->name;
                $user->save();

                $business = new Business();
                $business->user_id = $user->id;
                $business->bns_name = 'My Business';

                $business->save();
    
                $token = $user->createToken('API Token')->accessToken;
                return response()->json([
                    'message' => 'New user created with the mobile number and Otp verification succesfully completed',
                    'status' => '200',
                    'user' => $user,
                    'token' => $token,
                    'business' => $business,
                    
                    
                ]);
            }
            //return $user->createToken('API Token')->accessToken;
           
            $business = Business::where('user_id', $user->id)->first();
            if (!$business){     
                $business = new Business();
                $business->user_id = $user->id;
                $business->bns_name = 'My Business';
                $business->save();
            }
            $token = $user->createToken('API Token')->accessToken;
            return response()->json([
                'user' => $user,
                'message' => 'Otp verification succesfully completed',
                'status' => '200',
                'token' => $token,
                'business' => $business,
               
                //'otp' => $otp
            ]);
            
            
        }else{
            return response()->json([
                'message' => 'otp verification failed',
                'status' => 401,
               // 'token' => $token,
                //'otp' => $otp
            ]);
        }
    }

    public function update(Request $request, User $user){
        $request->validate([
            'email' => 'email',
            'mobile' => 'min:8'
        ]);

        // $user->username = $request->username;

        //$data = $request->all();
        $business = Business::where('user_id', Auth::user()->id)->first();

        if ($business){
            $business->bns_name = $request->bns_name;
            $business->user_id = Auth::user()->id;
            $business->bns_address = $request->bns_address;
            $business->bns_type = $request->bns_type;
            $business->gstin_no = $request->gstin_no;

            $business->save();
        }else{
            $business = new Business();

            $business->bns_name = $request->bns_name;
            $business->user_id = Auth::user()->id;
            $business->bns_address = $request->bns_address;
            $business->bns_type = $request->bns_type;
            $business->gstin_no = $request->gstin_no;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->pan_no = $request->pan_no;
        $user->aadhar_no = $request->aadhar_no;
        $user->voter_id = $request->voter_id;
    
        $user->business_name = $request->business_name;

        if ($request->hasFile('profile_image')){
            //return true;
            $path =  $user->profile_image;

            if ($path) {
                // return true;
                File::delete($path);
                $fileName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/profile_image"));
                $request->file('profile_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->profile_image =  $fileName;
            }else{
                $fileName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/profile_image"));
                $request->file('profile_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->profile_image =  $fileName;

            }
        }

        if ($request->hasFile('aadhar_image')){
            //return true;
            $path =  $user->aadhar_image;

            if ($path) {
                // return true;
                File::delete($path);
                $fileName = time() . '_' . $request->file('aadhar_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/aadhar_image"));
                $request->file('aadhar_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->aadhar_image =  $fileName;
            }else{
                $fileName = time() . '_' . $request->file('aadhar_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/aadhar_image"));
                $request->file('aadhar_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->aadhar_image =  $fileName;
            }
        }

        
        if ($request->hasFile('pan_image')){
            //return true;
            $path =  $user->pan_image;

            if ($path) {
                // return true;
                File::delete($path);
                $fileName = time() . '_' . $request->file('pan_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/pan_image"));
                $request->file('pan_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->pan_image =  $fileName;
            }else{
                $fileName = time() . '_' . $request->file('pan_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/pan_image"));
                $request->file('pan_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->pan_image =  $fileName;
            }
        }

          
        if ($request->hasFile('voter_id_image')){
            //return true;
            $path =  $user->voter_id_image;

            if ($path) {
                // return true;
                File::delete($path);
                $fileName = time() . '_' . $request->file('voter_id_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/voter_id_image"));
                $request->file('voter_id_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->voter_id_image =  $fileName;
            }else{
                $fileName = time() . '_' . $request->file('voter_id_image')->getClientOriginalName();
                $filePath = str_replace('\\', '/', public_path("assets/user/voter_id_image"));
                $request->file('voter_id_image')->move($filePath, $fileName);
                // $data['attachments']->name = time().'_'.$request->file->getClientOriginalName();
                $user->voter_id_image =  $fileName;
            }
        }


        
        $user->save();

        return response([
             'message' => 'user updated successfully',
            'user' => $user,
             'status' => 200
        ]);
        
    }

    public function show(User $user){
        if ($user){
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'user not found'
            ]);
        }
       
    }

    public function userBlock($id){
        $user = User::where('id', $id)->first();
        $user->block_status = !$user->block_status;
        $user->save();
        return back();
    }

}