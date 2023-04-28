<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $emailExists = User::where('email', $email)->first();
        // dd($emailExists);
        if($emailExists){
            $otp = mt_rand(100000, 999999);
            $expiresAt = Carbon::now('Asia/kolkata')->addMinutes(5);

            $saveData = Otp::insert([
                'user_id' => $emailExists->id,
                'otp' => $otp,
                'expire_time'=>$expiresAt, 
                'status'=>'A', 
            ]);

            $updateStats = Otp::where([
                ['status', '=', 'A'],
                ['expire_time', '<=', Carbon::now('Asia/kolkata')]
            ])->update(['status' => 'I']);

            $sendMail = Mail::to($email)->send(new OtpMail($otp));

            return response()->json(['message' => 'OTP sent to email']);
        }
        return response()->json(['message' => 'Email not registered']);

        
    }

    public function userLogin(Request $request)
    {
     $input = $request->all();
     $email = $input['email'];

     $emailExists = User::where('email', $email)->get();
     
        if ($emailExists->isEmpty()) {
            $message = "Invalid credentials";
            return view('login',compact('message'));
        } else{

                if (array_key_exists('otp', $input)) {
                    // OTP-based login
                    $otp = $input['otp'];
                    $otpUser = Otp::where('user_id', $emailExists[0]->id)->latest('created_at')->first();

                    if ($otpUser && $otpUser->otp == $otp && $otpUser->expire_time >= Carbon::now('Asia/kolkata')) 
                    {
                        $updateStatus =  Otp::where('user_id', '=', $emailExists[0]->id)
                        ->where('otp', '=', $otp)
                        ->update(['status' => 'U']);

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
                    $credentials = array(
                        'email' => $email,
                        'password'=> $password
                     );
                    // if ($emailExists[0]->email == $email && $emailExists[0]->password == $password)
                     if( Auth::attempt($credentials)) 
                    {
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
            ['status', '=', 'A'],
            ['expire_time', '<=', Carbon::now('Asia/kolkata')]
        ])->update(['status' => 'I']);

        Log::info('Expired OTPs updated successfully');
    }
}
