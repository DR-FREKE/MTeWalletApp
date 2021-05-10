<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSetup extends Model
{
    protected $fillable = ["account_name", "wallet_number", "account_balance", "user_id", "mobile_number", "country", "wallet_pin", "bvn"];
}
