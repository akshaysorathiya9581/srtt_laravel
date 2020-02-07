<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterClientSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_client_suggestions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->string('cont_coun_code');
            $table->string('phone_number');
            $table->string('whas_coun_code');
            $table->string('wtsapp_no');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_client_suggestions');
    }
}
