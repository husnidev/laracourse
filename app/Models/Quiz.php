<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('quizzes')]
class Quiz extends Model
{
    public $timestamps = false;
    public $fillable = ['lesson_id', 'title', 'duration', 'total_score', 'publish'];

    // public function lesson()
    // {
    //     return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    // }
}
