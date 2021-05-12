<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;


use App\Http\Controllers\Controller;
use App\Models\FundAccount;
use Illuminate\Http\Request;
use App\Models\AccountSetup;


class FundAccountController extends Controller
{
    public $pURL = "https://api.flutterwave.com/v3/charges?type=card";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(["msg"=>"welcome back"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get_callback_url = config('app.flw_callback_url');
        //validate request
        $validatedData = $this->validate($request, [
            "card_number"=>"required",
            "cvv"=>"required",
            "expiry_month"=>"required",
            "expiry_year"=>"required",
            "currency"=>"required",
            "amount"=>"required",
        ]);

        $validatedData["tx_ref"] = "TR_456fgj566yyy8";
        $validatedData["redirect_url"] = $get_callback_url;
        $validatedData["type"] = "card";
        $validatedData["email"] = $request->user()->email;

        $returns = $this->fetchData($request, $validatedData);

        $account_balance = AccountSetup::where('user_id', $request->user()->id)->get();

        return response()->json(["fund_data"=>$returns]);
    }

    public function fetchData($request, $requestData)
    {
        $flw_encrypt_key = config('app.flw_encrypt_key');
        $flw_key = config('app.flw_key');
        $data_encrypted = $this->encrytData(json_encode($requestData), $flw_encrypt_key);

        $fund = Http::withToken($flw_key)->post($this->pURL, [
            "client"=>$data_encrypted
        ]);

        $response = json_decode($fund->body());
        if($response->meta->authorization->mode){

            $authorization = $this->validate($request, [
                "city"=>"required",
                "address"=>"required",
                "state"=>"required",
                "country"=>"required",
                "zipcode"=>"required"
            ]);
            $authorization["mode"] = "avs_noauth";
            
            $requestData["authorization"] = $authorization;

            $fund = $this->fetchData($request, $requestData);

            $res = $fund;
            $flw_ref_code = $res->data->flw_ref;

            $verify_transfer = Http::withToken($flw_key)->post("https://api.flutterwave.com/v3/validate-charge", [
                "otp"=>12345,
                "flw_ref"=>$flw_ref_code,
                "type"=>"card"
            ]);

            return response()->json(json_decode($verify_transfer->body()));

        }
        return $response;
    }

    public function encrytData($data, $key){
        $encrytdata = openssl_encrypt($data, "DES-EDE3", $key, OPENSSL_RAW_DATA);

        return base64_encode($encrytdata);
    }

    public function callFlutterwave($client){

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FundAccount  $fundAccount
     * @return \Illuminate\Http\Response
     */
    public function show(FundAccount $fundAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FundAccount  $fundAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FundAccount $fundAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FundAccount  $fundAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundAccount $fundAccount)
    {
        //
    }
}
