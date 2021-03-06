<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Models\User;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // for validating and giving json response
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccountController;

class RegisterController extends Controller
{
    //

    public function index(){
        //
        return response()->json(["msg"=>"welcome to the app."]);
    }

    public function store(Request $request){
        DB::beginTransaction();
        
        try {

            //validate request coming in from user
            $validatedData = $this->validate($request, [
                "name"=>"required|max:255",
                "email"=>"required|email|max:255",
                "phone_number"=>"required|max:50",
                "password"=>"required|confirmed",
                "password_confirmation"=>"required"
            ]);
    
            // hash password before storing it into database
            $validatedData["password"] = Hash::make($request->password);
    
            //store the user into the database
            $user = User::create($validatedData);
    
            //generate token for user login
            $token = $user->createToken('authToken')->accessToken;
    
            AccountController::store($user);

        } catch (ValidationException $e) {
            DB::rollback();
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }

        DB::commit();
        return response()->json(["user"=>$user, "token"=>$token]);

    }
}
