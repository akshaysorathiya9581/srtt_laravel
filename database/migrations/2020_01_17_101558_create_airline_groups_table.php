<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlineGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
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
        Schema::dropIfExists('airline_groups');
    }
}
