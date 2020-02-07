<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaxProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pax_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_code')->nullable();
            $table->integer('ref_id')->nullable();    
            $table->integer('client_id'); 
            $table->string('meal_preference')->nullable();   
            $table->string('seat_preference')->nullable();
            $table->integer('created_by')->default(0);   
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);    
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
        Schema::dropIfExists('pax_profiles');
    }
}
