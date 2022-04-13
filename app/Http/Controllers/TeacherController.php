<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    const LANG_KZ = "kk";
    const LANG_RU = "ru";
    const LANG_KZ_RU = "kk_ru";
    const LANG_LIST = "kk,ru,kk_ru";

    /**
     * препод = 'teacher'
     * завуч = 'head'
     */
    const POSITIONS_LIST = "teacher,head";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name       = $request->input('name', "");
        $schoolIds  = $request->input('school_ids', []);
        $subjectIds = $request->input('subject_ids', []);
        $langs      = $request->input('langs', []);
        $positions  = $request->input('positions', []);
        $coursesOn  = $request->input('courses_on', []);
        $coursesNot = $request->input('courses_not', []);
        $limit      = $request->input('limit', 15);
        $page       = $request->input('page', 1);

        $queryBuilder = DB::table('teachers')
            ->select('teachers.*', 'schools.name as school_name', 'subjects.name as subject_name')
            ->join('schools', 'teachers.school_id', '=', 'schools.id')
            ->join('subjects', 'teachers.subject_id', '=', 'subjects.id')
            ->leftJoin('course_teacher', 'teachers.id', '=', 'course_teacher.teacher_id')
            ->where('teachers.is_active', TRUE)
            ->when($name, function($query, $name) {
                return $query->where('teachers.name', 'like', '%'.$name.'%');
            })
            ->when($langs, function($query, $langs) {
                return $query->whereIn('teachers.lang', $langs);
            })
            ->when($positions, function($query, $positions) {
                return $query->whereIn('teachers.position', $positions);
            })
            ->when($schoolIds, function($query, $schoolIds) {
                return $query->whereIn('schools.id', $schoolIds);
            })
            ->when($subjectIds, function($query, $subjectIds) {
                return $query->whereIn('subjects.id', $subjectIds);
            })
            ->when($coursesOn, function($q, $coursesOn) {
                return $q->where(function($query) use ($coursesOn) {
                    foreach ($coursesOn as $course) {
                        $value = json_decode($course, true);
                        if(isset($value['before'])) {
                            $query->orWhere(function($subQuery) use ($value) {
                                $subQuery->where('course_teacher.course_id', $value['id'])
                                         ->whereYear('course_teacher.done_date', '<=', $value['year']);
                            });
                        } else {
                            $query->orWhere(function($subQuery) use ($value) {
                                $subQuery->where('course_teacher.course_id', $value['id'])
                                         ->whereYear('course_teacher.done_date', $value['year']);
                            });
                        }
                    }
                });
            });

        $sql_with_bindings = Str::replaceArray('?', $queryBuilder->getBindings(), $queryBuilder->toSql());
        if (!empty($coursesNot)) {
            $notThatTeachersSQL = "(SELECT * FROM (SELECT DISTINCT `teacher_id` FROM `course_teacher` WHERE `course_id` IN (".implode(",", $coursesNot).")) AS subquery)";
                                $aa = DB::table('course_teacher')
                                ->selectRaw('DISTINCT teacher_id')
                                ->whereIn('course_id', $coursesNot);

            $sql_with_bindings .= " AND `course_teacher`.`teacher_id` NOT IN ".$notThatTeachersSQL;
        }

        $sql_with_bindings .= " GROUP BY `teachers`.`id` HAVING COUNT(*) >= ".count($coursesOn);

        $total = DB::select("SELECT COUNT(*) as total FROM ( ".$sql_with_bindings." ) as tt")[0]->total;
        $data  = DB::select($sql_with_bindings." LIMIT ".$limit." OFFSET ".($page-1)*$limit);
        // $total = $queryBuilder->selectRaw('teachers.*, COUNT(DISTINCT teachers.id) as total')->get();//->first()->total;
//         $queryBuilder->groupBy('teachers.id')->havingRaw('COUNT(*) >= ?', [count($coursesOn)]);
//         $data = $queryBuilder->offset(($page-1)*$limit)->limit($limit)->get();

        $pagination = [
            'total'         => $total,
            'current_page'  => $page,
            'last_page'     => ceil($total/$limit),
            'per_page'      => $limit,
            'data'          => $data
        ];

        return response()->json($pagination, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'lang' => 'required|in:'.self::LANG_LIST,
            'school_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'stazh' => 'required',
        ]);

        $teacher = new Teacher();
        $teacher->name          = $request->name;
        $teacher->phone         = $request->phone;
        $teacher->birth_date    = $request->birth_date;
        $teacher->lang          = $request->lang;
        $teacher->school_id     = $request->school_id;
        $teacher->subject_id    = $request->subject_id;
        $teacher->stazh         = $request->stazh;

        if ($teacher->save()) {
            return response()->json($teacher, 200);
        }
        return response()->json($request->all(), 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::where('id', $id)->with('courses')->firstOrFail();

        return response()->json($teacher, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'lang' => 'required',
            'birth_date' => 'required',
            'additional_info' => 'required',
            'is_active' => 'required',
            'position' => 'required|in:'.self::POSITIONS_LIST,
            'school_id' => 'required',
            'subject_id' => 'required',
            'stazh' => 'required',
        ]);

        $teacher->name              = $request->name;
        $teacher->phone             = $request->phone;
        $teacher->lang              = $request->lang;
        $teacher->birth_date        = $request->birth_date;
        $teacher->additional_info   = $request->additional_info;
        $teacher->is_active         = $request->is_active;
        $teacher->position          = $request->position;
        $teacher->school_id         = $request->school_id;
        $teacher->subject_id        = $request->subject_id;
        $teacher->stazh             = $request->stazh;

        if ($teacher->save()) {
            return response()->json($teacher, 200);
        }

        return response()->json($teacher, 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Attach course to teacher by $id
     *
     * @param  int  $teacher
     * @param  int  $course
     * @return \Illuminate\Http\Response
     */
    public function attachCourse($teacherId, $courseId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $course = Course::findOrFail($courseId);
        $doneDate = Carbon::now()->format('Y-m-d');

        $pivotId = bin2hex(random_bytes(20));
        $teacher->courses()->attach($course->id, ['pivot_id' => $pivotId, 'done_date' => $doneDate]);

        $response = $teacher->courses()
                        ->where('id', $courseId)
                        ->wherePivot('done_date', $doneDate)
                        ->wherePivot('pivot_id', $pivotId)
                        ->firstOrFail();
        return response()->json($response, 200);
    }

    /**
     * Detach course from teacher by $id
     *
     * @param  int  $teacher
     * @param  int  $course
     * @return \Illuminate\Http\Response
     */
    public function detachCourse($teacherId, $courseId, Request $request)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $teacher->courses()->where('id', $courseId)
                           ->wherePivot('pivot_id', $request->pivot_id)
                           ->detach();

        return response()->json(TRUE, 200);
    }
}
