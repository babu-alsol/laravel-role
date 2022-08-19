<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            // 'name' => 'required|max:255',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|confirmed',
            'mobile' => 'required'
        ]);

       // $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $otp = new Otp();
        $otp->mobile = $request->mobile;
        $otp->otp = rand(1000,9999);
        $otp->save();

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token, 'otp' => $otp]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            // 'email' => 'email|required',
            // 'password' => 'required'
            'mobile' => 'required'      
        ]);

        // if (!auth()->attempt($data)) {
        //     return response(['error_message' => 'Incorrect Details. 
        //     Please try again']);
        // }

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

            $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'message' => 'mobile number is not resgistered, new user created with the mobile number',
                'status' => '200',
                'user' => auth()->user(),
                'token' => $token,
                'otp' => $otp
            ]);
        }
        //return $user->createToken('API Token')->accessToken;
        $otp = new Otp();
        $otp->mobile = $user->mobile;
        $otp->otp = rand(1000,9999);
        $otp->save();
        $token = $user->createToken('API Token')->accessToken;
        return response()->json([
            ['user' => $user],
            'message' => 'otp send to your mobile number',
            'status' => '200',
            'token' => $token,
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
}