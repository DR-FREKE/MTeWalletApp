<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_setups', function (Blueprint $table) {
            $table->id();
            $table->string("account_name");
            $table->string("wallet_number");
            $table->double("account_balance")->default(0.00);
            $table->string("mobile_number");
            $table->string("country");
            $table->string("wallet_pin")->default("");
            $table->string("bvn");
            $table->unsignedInteger("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_setups');
    }
}
