<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('f_name');
            $table->string('m_name')->nullable();
            $table->string('l_name');
            $table->string('place');
            $table->date('dob')->nullable();;
            $table->string('gender')->nullable();;
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
        Schema::dropIfExists('master_clients');
    }
}
