<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\Course;
use Carbon\Carbon;

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
    public function index()
    {
        //
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
