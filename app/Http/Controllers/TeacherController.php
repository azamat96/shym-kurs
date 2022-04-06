<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

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
        $teacher = Teacher::where('id', $id)->firstOrFail();
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
}
