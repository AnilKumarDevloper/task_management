<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function SuperAdminLoginCreate(){ 
        return view('auth/login');
    }
    public function SuperAdminLoginStore(LoginRequest $request){
      
        $request->authenticate(); 
        $request->session()->regenerate(); 
        $user = Auth::user();  
        $token = $user->createToken('API Token')->plainTextToken; 
        return redirect('/admin/dashboard?token='.$token);
    }
}
