<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function showLogin(){
        return response()->view('cms.auth.login');
    }
    public function login(Request $request){
        $vaild = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
            'remember'=> 'required|boolean',
        ]);
        if(!$vaild->fails()){
            $credentials = ['email'=>$request->input('email'),'password'=>$request->input('password')];
            if(Auth::guard('admin')->attempt($credentials, $request->input('remember'))){
                return response()->json(['message'=> 'Logged in successfully'] , Response::HTTP_OK);
            }else{
                return response()->json(['message'=> 'Login Failed , Check email or password']
                , Response::HTTP_BAD_REQUEST);
            }
        }
        else{
            return response()->json(['message'=> $vaild->getMessageBag()->first()] , Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->guest(route('cms.login'));
    }

    public function forgotPassword(){
        return response()->view('cms.auth.forgot-password');
    }

    public function sendResetEmail(Request $request){

    }
}
