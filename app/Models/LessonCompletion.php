<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('lesson_completions')]
class LessonCompletion extends Model
{
    public $timestamps = false;
    public $fillable = ['lesson_id', 'student_id', 'completed_at'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
