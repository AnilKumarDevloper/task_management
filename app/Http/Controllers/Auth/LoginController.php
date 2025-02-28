<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Auth;
use Crypt;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function SuperAdminLoginCreate(){ 
        return view('auth/login');
    }
    public function SuperAdminLoginStore(LoginRequest $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try{
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        $user = User::where('email', $request->email)->withTrashed()->first();
        if (!$user || !Hash::check($request->password, $user->password)){   
            return back()->withErrors(['error' => 'Invalid credentials']);
        }else if($user->status == 0){
            return back()->withErrors(['error' => 'Your account is temporarily inactive. Please contact the administrator for further assistance.']);
        }
        $otp = rand(1000, 9999);
        User::where('id', $user->id)->update(
          [
            'otp' => $otp
          ]
        );
        $otp_mail_data = [
            "otp" => $otp   
        ];
        Mail::to($request->email)->send(new OtpMail($otp_mail_data));
        $encrypt_user_id = Crypt::encrypt($user->id);
        return redirect()->route('verify_otp_view', [$encrypt_user_id]);  
    }catch(\Exception $e){
        return "Something went wrong.";
    }
    }

    public function SuperAdminLoginVerifyOtpView($id){
        try{ 
            $decrypt_id = Crypt::decrypt($id);
            return view('auth.verify_otp', compact('decrypt_id'));
        }catch(\Exception $e){
            abort('404');
        }
    }

    public function SuperAdminLoginVerifyOtp(Request $request){
        try{
            $otp = $request->otp;
            $user_id = $request->user_id; 
            if($otp != '' && $user_id != ''){
                $user = User::where('id', $user_id)->first();
                if($user->otp == $otp){
                Auth::login($user);
                $request->session()->regenerate();
                $token = $user->createToken('API Token')->plainTextToken;
                User::where('id', $user->id)->update(
                    [
                      'otp' => NULL
                    ]
                  );
                return redirect('/admin/dashboard?token='.$token);
                }else{
                    return back()->withErrors(['error' => 'Invalid OTP']);
                }
            }else{
                return back()->withErrors(['error' => 'Invalid OTP']);
            }
        }catch(\Exception $e){
            abort('404');
        }
    }
}
