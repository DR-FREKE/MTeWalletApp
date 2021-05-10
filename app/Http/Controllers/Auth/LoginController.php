<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        //
    }

    //function to log user in
    public function userLogin(Request $request){
        $validatedData = $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required'
        ]);

        //check if value entered is false
        if(!auth()->attempt($validatedData)){
            return response()->json(["err_msg"=>"Invalid login details"]);
        }

        //generate token for user login
        $token = auth()->user()->createToken('authToken')->accessToken;
        return response()->json(["user"=>auth()->user(), "token"=>$token]);
    }
}
