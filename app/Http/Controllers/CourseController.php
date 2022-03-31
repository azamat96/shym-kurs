<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isActive = $request->query('is_active', true);
        $courses = Course::where('is_active', $isActive)->orderBy('updated_at', 'desc')->get();
        return response()->json($courses, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'name' => 'required|min:3',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;

        if ($course->save()) {
            return response()->json($course, 200);
        }

        return response()->json($course, 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $course = Course::find($id);
        if ($request->has('name')) {
            $request->validate([
                'name' => 'required|min:3',
            ]);
            $course->name = $request->name;
        }
        if ($request->has('name')) {
            $course->description = $request->description;
        }
        if ($request->has('is_active')) {
            $course->is_active = $request->is_active;
        }

        if ($course->save()) {
            return response()->json($course, 200);
        }

        return response()->json($course, 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Course::destroy($id), 200);
    }
}
