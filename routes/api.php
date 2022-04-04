<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('course', 'CourseController')->except(['create', 'show', 'edit']);
Route::resource('schools', 'SchoolController')->only(['index']);
Route::resource('subjects', 'SubjectController')->only(['index']);
Route::resource('teachers', 'TeacherController')->except(['create', 'edit']);
