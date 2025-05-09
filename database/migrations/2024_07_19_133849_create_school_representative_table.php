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
        Schema::create('school_representative', function (Blueprint $table) {
            //$table->id();
            $table->timestamps();
            $table->string('school_name');
            $table->string('school_district');
            $table->string('school_phone');
            $table->id('school_regNo');
            $table->string('rep_email');
            $table->string('rep_name');
            $table->string('rep_username');
            $table->string('rep_phone');
            $table->string('rep_password');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_representative');
    }
};
