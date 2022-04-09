<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_teacher', 'teacher_id', 'course_id')
                    ->withTimestamps()
                    ->withPivot('pivot_id', 'done_date')
                    ->orderBy('course_teacher.created_at', 'desc');
    }

    public function school() {
        return $this->belongsTo('App\School');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }
}
