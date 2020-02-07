<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlinelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlinelists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('membership_plan');
            $table->integer('airline_group');
            $table->enum('airline_gst', ['0', '1'])->default('0');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('url')->nullable();
            $table->string('image');
            $table->integer('deleted_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('airlinelists');
    }
}
