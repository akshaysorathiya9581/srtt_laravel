<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membershipcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('airline_id')->comment('airline_id.airlinelists');
            $table->string('membership_number');
            $table->string('password');
            $table->string('email');
            $table->string('phone_number');
            $table->string('securi_quest');
            $table->string('secu_ques_ans');
            $table->string('family_program');
            $table->string('family_head');
            $table->text('attached')->nullable();
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
        Schema::dropIfExists('membershipcards');
    }
}
