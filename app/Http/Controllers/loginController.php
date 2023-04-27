<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use DB;
class loginController extends Controller
{
    //
    public function index()
    {       
        $message = '';
        return view('login',compact('message')); 
    }

    public function generateOtp(Request $request)
    {

        $email = $request ->email;
        $emailExists = \DB::table('users')->where('email', $email)->first();
        // dd($emailExists);
        if($emailExists){
            $otp = mt_rand(100000, 999999);
            $expiresAt = Carbon::now('Asia/kolkata')->addMinutes(5);

            $saveData = \DB::table('otp')->insert([
                'user_id' => $emailExists->id,
                'otp' => $otp,
                'expire_time'=>$expiresAt, 
                'status'=>'A', 
            ]);
            $sendMail = Mail::to($email)->send(new OtpMail($otp));

            return response()->json(['message' => 'OTP generated successfully']);
        }
        return response()->json(['message' => 'Email not registered']);

        
    }

    public function userLogin(Request $request)
    {
     $input = $request->all();
     $email = $input['email'];
     
     $updateStats = DB::table('otp')->where([
        ['status', '=', 'active'],
        ['expire_time', '<=', Carbon::now('Asia/kolkata')]
    ])->update(['status' => 'I']);

     $emailExists = \DB::table('users')->where('email', $email)->get();
     $otpUser = \DB::table('otp')->where('user_id', $email)->latest('created_at')->first();

        // dd($otpUser->expire_time >= Carbon::now('Asia/kolkata'));
     if ($emailExists->isEmpty()) {
        $message = "Invalid credentials";
        return view('login',compact('message'));
    } else{


        if (array_key_exists('otp', $input)) {
        // OTP-based login
            $otp = $input['otp'];
            if ($otpUser && $otpUser->otp == $otp && $otpUser->expire_time >= Carbon::now('Asia/kolkata')) 
            {
                $updateStatus =  DB::table('otp')
                ->where('user_id', '=', $email)
                ->where('otp', '=', $otp)
                ->update(['status' => 'U']);

                    // return response()->json(['message' => 'Login successful']);
                echo "login successfully";
            } 
            else {
                $message = "Wrong OTP entered";
                return view('login', compact('message'));
            }
        } 
        elseif (array_key_exists('password', $input)) {
         //password based loign
            $password = $input['password'];
            if ($emailExists[0]->email == $email && $emailExists[0]->password == $password) {
                echo "login successfully";  
            }
            else{
                $message = "Wrong password entered";
                return view('login', compact('message'));
            }
        }
     }    

    }

    public function expiredOtpStatus()
    {
        $OtpStatus = DB::table('otp')->where([
            ['status', '=', 'active'],
            ['expire_time', '<=', Carbon::now('Asia/kolkata')]
        ])->update(['status' => 'inactive']);

        Log::info('Expired OTPs updated successfully');
    }
}
