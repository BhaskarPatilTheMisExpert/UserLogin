<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DateTimeZone;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class loginController extends Controller
{
    //
    public function index(Request $request)
    {       
        $message = '';
        // dd($request);
        return view('login',compact('message','request')); 
    }

    public function generateOtp(Request $request)
    {
        $inactiveOtpStatus = Otp::where('status', 'A')
                            ->where('expire_time', '<', Carbon::now('Asia/Kolkata'))
                            ->update(['status' => 'I']);
        // return response()->json($inactiveOtpStatus);

            $email = $request->email;
            
            $emailExists = User::where('email', $email)->first();

            if ($emailExists) {
                if ($emailExists->status === 'A') {
                    $existingOtp = Otp::where('user_id', $emailExists->id)
                    ->where('status', 'A')
                    ->where('expire_time', '>', Carbon::now('Asia/Kolkata'))
                    ->first();

                    if ($existingOtp) {
                    // return response()->json(['message' => 'OTP is already active, no new OTP generated']);
                        $expireAt = Carbon::now('Asia/Kolkata')->addMinutes(5);

                        $renewOtp = Otp::where('user_id', $emailExists->id)
                        ->where('status', 'A')
                        ->update(['expire_time' => $expireAt]);
                        $sendMail = Mail::to($email)->send(new OtpMail($existingOtp->otp));

                    return response()->json(['message' => 'OTP already sent']);
                        // return response()->json($existingOtp->otp);
                    }
                    else{

                        $otp = mt_rand(100000, 999999);
                        $expiresAt = Carbon::now('Asia/Kolkata')->addMinutes(5);

                        $saveData = Otp::insert([
                            'user_id' => $emailExists->id,
                            'otp' => $otp,
                            'expire_time' => $expiresAt,
                            'status' => 'A',
                        ]);

                        $sendMail = Mail::to($email)->send(new OtpMail($otp));

                    // return response()->json(['message' => 'OTP generated and sent to registered email']);
                        return response()->json($otp);
                    }
                }
                else {
                    return response()->json(['message' => 'You are not active user. Please connect with support team.']);
                }
            }
            else{

                return response()->json(['message' => 'Email not registered']);
            }

            

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
                            //password based loign
                            $password = $input['password'];
                            $credentials = array(
                                'email' => $email,
                                'password'=> $password
                            );

                            // $remember_me = $request->has('remember_me') ? true : false;
                            // dd($remember_me);
                            if(Auth::attempt($credentials)) 
                            {
                                $message = "login successfully"; 
                                return view('login',compact('message')); 
                            }
                            else{
                               $otp = $input['password'];
                               // dd($otp);
                               $currentTime = Carbon::now('Asia/kolkata');

                               $query = Otp::where('user_id', $emailExists[0]->id)
                               ->where('otp', $otp)
                               ->where('expire_time', '>=', $currentTime)
                               ->orderBy('created_at', 'desc')
                               ->get();
                                // dd($query);
 
                               if ($query->isNotEmpty()) 
                               {
                                echo "login successfully";
                                // return view('login');
                               } 
                               else
                               {
                                echo"invalid otp / password";
                               }

                            } 
            }
                
    }

    public function getEmail(Request $request)
    {
        // dd($request);
        $message = '';
        $getEncrptEmail = $request->query('email');

        $email = Crypt::decryptString($getEncrptEmail);
        // dd($email);

        return view('login',compact('email','message'));

    }

   
public function expiredOtpStatus()
    {
    //     $OtpStatus = DB::table('otp')->where([
    //         ['status', '=', 'A'],
    //         ['expire_time', '<=', Carbon::now('Asia/kolkata')]
    //     ])->update(['status' => 'I']);

    //     Log::info('Expired OTPs updated successfully');
    }
}
