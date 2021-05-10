<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\AccountSetup;
use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all account here
        $all_account = AccountSetup::all();
        return response()->json(["accounts"=>AccountResource::collection($all_account), "message"=>"Account retrieved successfully"], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($request)
    {
        /**generate an account for registered user*/

        AccountSetup::create([
            "account_name"=>$request->name,
            "wallet_number"=>$request->phone_number,
            "account_balance"=>0.00,
            "mobile_number"=>$request->phone_number,
            "country"=>"Nigeria",
            "bvn"=>"",
            "user_id"=>$request->id
        ]);
        return response()->json(["msg"=>$request->name]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountSetup  $accountSetup
     * @return \Illuminate\Http\Response
     */
    public function show(AccountSetup $accountSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountSetup  $accountSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountSetup $accountSetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountSetup  $accountSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountSetup $accountSetup)
    {
        //
    }
}
