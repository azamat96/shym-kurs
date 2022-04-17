<?php

use Illuminate\Database\Seeder;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( $xlsx = SimpleXLSX::parse(storage_path('app').'\Технология _ Көркем еңбек (Ответы).xlsx') ) {
            $subject = DB::table('subjects')->selectRaw('*')->where('name', $xlsx->rows()[1][5])->first();
            if (!$subject) {
                return print_r("УРОК НЕ НАЙДЕН:[".$xlsx->rows()[1][5]."] \n");
            }
            $schools = DB::table('schools')->selectRaw('*')->get();

            for ($i = 1; $i < count($xlsx->rows()); $i++) {
                $row = $xlsx->rows()[$i];
                if (isset($row)) {
                    $school = $this->findObjectByName($row[2], $schools);
                    $lang   = $this->getLang($row[6]);
                    $teacher = [
                        'name' => $row[3],
                        'birth_date' => $this->getBirthDate($row[4]),
                        'lang' => $lang,
                        'position' => 'teacher',
                        'stazh' => $row[7],
                        'additional_info' => $row[12],
                        'phone' => $row[13],
                        'subject_id' => $subject->id,
                        'school_id' => $school->id
                    ];
                    if (DB::table('teachers')->insert($teacher)) {
                        print_r(($i+1).".Строка. Добавлен тичер.".($row[3])." \n");
                    } else {
                        print_r(($i+1).".Строка. Ошибка добавления.".($row[3])." \n",$school,$lang);
                    }
                }
            }
        } else {
            echo SimpleXLSX::parseError();
        }
    }

    private function findObjectByName($name, $array)
    {
        foreach ( $array as $item ) {
           if ( $name == $item->name ) {
               return $item;
           }
        }

        throw new Exception('Объект не найден в списке');
    }

    private function getLang($name)
    {
        if ($name == 'қазақ/орыс тілдерінде' || $name == "қазақ/орыс сыныптарына") {
            return "kk_ru";
        }
        if ($name == 'қазақ тілінде' || $name == "қазақ сыныптарына") {
            return "kk";
        }
        if ($name == 'орыс тілінде' || $name == "орыс сыныптарына") {
            return "ru";
        }
        throw new Exception('Язык предмета не найден');
    }

    private function getBirthDate($excelDate)
    {
        if (strpos($excelDate, "/") !== false) {
            $pieces = explode("/", $excelDate);
            $god = (int)substr($pieces[2], -2);
            $year = $god > 22 ? '19'.$god : '20'.$god;
            return Carbon::createFromDate($year, $pieces[0], $pieces[1])->format('Y-m-d');
        }

        return $excelDate;
    }
}
