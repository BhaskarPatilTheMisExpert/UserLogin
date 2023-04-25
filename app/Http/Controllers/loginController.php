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
            $expiresAt = Carbon::now()->addMinutes(5);

            $saveData = \DB::table('otp_table')->insert([
                'user_id' => $email,
                'otp' => $otp,
                'expire_time'=>$expiresAt, 
                'status'=>'active', 
            ]);
            $sendMail = Mail::to($email)->send(new OtpMail($otp));

            return response()->json(['message' => 'OTP generated successfully']);
        }
        return response()->json(['message' => 'Email not registered']);

        
    }

    public function userLogin(Request $request)
    {
     $input = $request->all();
     $email = $request->input('email');
     $otp = $request->input('password');

     $updateStats = DB::table('otp_table')->where([
                                ['status', '=', 'active'],
                                ['expire_time', '<=', Carbon::now()]
                                 ])->update(['status' => 'inactive']);
     $emailExists = \DB::table('users')->where('email', $email)->get();

     // dd($emailExists);
     if ($emailExists->isEmpty()) {
        $message = "Invalid credentials";
        return view('login',compact('message'));
    }
       // dd($emailExists[0]);
     $otpUser = \DB::table('otp_table')->where('user_id', $email)->latest('created_at')->first();

        if ($emailExists) {
            // dd($emailExists[0]);
              //for password login
            if ($emailExists[0]->email == $email && $emailExists[0]->password == $otp) {
                echo "login successfully";  
            }
            elseif($emailExists){
                //for otp login
                if ($otpUser && $otpUser->otp == $otp && $otpUser->expire_time >= Carbon::now()) 
                {
                    $updateStatus =  DB::table('otp_table')
                    ->where('user_id', '=', $email)
                    ->where('otp', '=', $otp)
                    ->update(['status' => 'used']);

                    // return response()->json(['message' => 'Login successful']);
                    echo "login successfully";
                } 
                else {
                        $message = "Wrong email or password";
                       return view('login', compact('message'));
                    // return view('login');
                 }
            }
            else
            {
                // echo"password not valid";
               $message = "Wrong email or password";
               return view('login', compact('message'));
            }
        }
        else
        {
            // return view('login');
           $message = "Wrong email or password";
           return view('login', compact('message'));
        }

    }

    public function expiredOtpStatus()
    {
        $OtpStatus = DB::table('otp_table')->where([
            ['status', '=', 'active'],
            ['expire_time', '<=', Carbon::now()]
        ])->update(['status' => 'inactive']);

        Log::info('Expired OTPs updated successfully');
    }
}
