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
    Schema::create('participant_answer', function (Blueprint $table) {
        $table->unsignedBigInteger('participant_answer_id');
        $table->id('participant_challenge_id');
        $table->string('question_id', 300);
        $table->string('answer', 50);
        $table->integer('marks')->default(1);
        $table->timestamps();
        $table->foreign('participant_challenge_id')->references('challenge_id')->on('challenge');


    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participantant_answer');
    }
};
