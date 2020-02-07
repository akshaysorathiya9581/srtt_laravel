<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id')->comment('client_id.master_clients');
            $table->string('passport_number');
            $table->date('issue_date');
            $table->string('issue_place');
            $table->date('expiry_date');
            $table->string('ecr');
            $table->integer('country_id')->comment('country_id.ak_countries');
            $table->text('attached');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passports');
    }
}
