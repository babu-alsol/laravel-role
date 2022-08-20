<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bns_id');
            // $table->unsignedBigInteger('bns_id');
             $table->string('account_holder_name');
             $table->string('upi_id');
             $table->string('account_no');
             $table->string('ifsc');
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
        Schema::dropIfExists('business_banks');
    }
};
