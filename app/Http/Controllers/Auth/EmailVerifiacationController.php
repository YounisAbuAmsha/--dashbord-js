<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiacationController extends Controller
{
    public function notice(){
        return response()->view('cms.auth.verify-notice');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent'] , Response::HTTP_OK);
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect()->route('home');
    }
}
