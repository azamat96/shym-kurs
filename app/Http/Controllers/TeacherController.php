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
        dd($request->all());
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
