<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('enrollments')]
class Enrollment extends Model
{
    public $timestamps = false;
    public $fillable = ['course_id', 'student_id', 'enrolled_at', 'progress', 'status'];
    protected $casts = [ 'progress' => 'integer', 'enrolled_at' => 'datetime'];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
