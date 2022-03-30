<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('birth_date');
            $table->string('lang', 50);
            $table->string('stazh');
            $table->text('additional_info')->nullable();
            $table->string('phone');
            $table->boolean('is_active')->default(true);
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();

            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('school_id')->references('id')->on('schools');
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
        Schema::dropIfExists('teachers');
    }
}
