<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertAllSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('subjects')->insert([
            ['name' => 'Ағылшын тілі'],
            ['name' => 'Бастауыш сынып'],
            ['name' => 'Биология'],
            ['name' => 'География'],
            ['name' => 'Дене шынықтыру'],
            ['name' => 'Информатика'],
            ['name' => 'қазақ тілі мен әдебеиті'],
            ['name' => 'Құқық негіздері / Адам және қоғам'],
            ['name' => 'Математика, алгебра, геометрия'],
            ['name' => 'Музыка'],
            ['name' => 'орыс тілі мен әдебеиті'],
            ['name' => 'Технология / көркем еңбек'],
            ['name' => 'Физика'],
            ['name' => 'Химия'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('subjects')->delete();
    }
}
