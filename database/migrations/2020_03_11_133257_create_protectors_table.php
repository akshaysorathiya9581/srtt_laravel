<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_code')->nullable();
            $table->integer('   ')->nullable();
            $table->text('login_for');
            $table->integer('service_id')->comment('service_id.services');
            $table->string('terminal_id');
            $table->string('name');
            $table->string('password');
            $table->text('website');
            $table->string('contact_number');
            $table->string('support_name');
            $table->string('support_number');
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
        Schema::dropIfExists('protectors');
    }
}
