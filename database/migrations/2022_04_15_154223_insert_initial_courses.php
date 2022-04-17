<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertInitialCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('courses')->insert([
            ['name' => 'Жаңартылған білім беру'],
            ['name' => 'Пән бойынша қысқа мерзімді'],
            ['name' => 'Бағалау'],
            ['name' => 'Деңгейлік']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('courses')->delete();
    }
}
