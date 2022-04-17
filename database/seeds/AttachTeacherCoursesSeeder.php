<?php

use Illuminate\Database\Seeder;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttachTeacherCoursesSeeder extends Seeder
{
    const JANARTILGAN_ID = 1;
    const PAN_ID = 2;
    const BAGA_ID = 3;
    const DENGEI_ID = 4;
    const COURSES = [1,2,3,4];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( $xlsx = SimpleXLSX::parse(storage_path('app').'\Технология _ Көркем еңбек (Ответы).xlsx') ) {
            for ($i = 1; $i < count($xlsx->rows()); $i++) {
                $row = $xlsx->rows()[$i];
                $inserts = [];
                $teacher = DB::table('teachers')->where([
                    ['name', '=', $row[3]],
                    ['phone', '=', $row[13]]
                ])->first();
                if (!$teacher) {
                    print_r(($i+1).". Тичер с строка не найден.".$row[3]."\n", $teacher);
                    continue;
                }

                for ($j = 0; $j < 4; $j++) {
                    if (!($row[$j+8] == "өткен жоқ" || $row[$j+8] == "өткен жылы")) {
                        $doneYear = preg_replace('/[^0-9]/', '', $row[$j+8]);
                        $doneYear = Carbon::createFromDate($doneYear,1,1);
                        if ($doneYear->toDateString() == Carbon::now()->toDateString()) {
                            print_r(($i+1).". Ошибка времени с строка.".$row[3]." \n", $inserts);
                        }
                        $pivotId = bin2hex(random_bytes(20));
                        $inserts[] = [
                            'pivot_id'      => $pivotId,
                            'teacher_id'    => $teacher->id,
                            'course_id'     => self::COURSES[$j],
                            'done_date'     => $doneYear->format('Y-m-d')
                        ];
                    }
                }
                if (!empty($inserts)) {
                    if (DB::table('course_teacher')->insert($inserts)) {
                        print_r(($i+1).". Тичеру с строка курсы добавлены.".$row[3]." \n");
                    } else {
                        print_r(($i+1).". Ошибка тичеру с строка курсы НЕ добавлены.".$row[3]." \n", $inserts);
                    }
                } else {
                    print_r(($i+1).". Тичер с строка нет курсов.".$row[3]." \n");
                }
            }
        } else {
            echo SimpleXLSX::parseError();
        }
    }
}
