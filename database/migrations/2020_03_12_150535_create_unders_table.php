<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUndersTable extends Migration
{
    public function up()
    {
        Schema::create('unders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_code')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('name');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unders');
    }
}
