<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\School;
use Illuminate\Support\Facades\DB;

class InsertAllSchools extends Migration
{
    private $schools = [
        'Дарын №1','Дарын №2','БИЛ №1','БИЛ №2','Кешкі мектеп №1','Кешкі мектеп №2','Кешкі мектеп №3','Кешкі мектеп №4',
        'Үміт арн мектеп','Қосалқы көмекші арн мек','1 құлағы нашар ест арн.мек','2 құлағы нашар ест арн.мек'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $inserts = [];
        for ($x = 1; $x <= 139; $x++) {
            array_push($inserts, ['name' => '№'.$x]);
        }
        foreach ($this->schools as $school) {
            array_push($inserts, ['name' => $school]);
        }
        DB::table('schools')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('schools')->delete();
    }
}
