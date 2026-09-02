<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public $timestamps = false;
    public $fillable = ['teacher_id', 'category_id', 'title', 'slug', 'description', 'thumbnail', 'level', 'duration', 'price', 'status'];

}
