<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
    });
});

Route::resource('course', 'CourseController')->except(['create', 'show', 'edit']);
Route::resource('schools', 'SchoolController')->only(['index']);
Route::resource('subjects', 'SubjectController')->only(['index']);
Route::resource('teachers', 'TeacherController')->except(['create', 'edit']);
Route::put('teachers/{teacher}/course/{course}', 'TeacherController@attachCourse');
Route::delete('teachers/{id}/course/{course}', 'TeacherController@detachCourse');
