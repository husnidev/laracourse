<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('lessons')]
class Lesson extends Model
{
    public $timestamps = false;
    public $fillable = ['module_id', 'title', 'content', 'video_url', 'duration', 'sequence'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'lesson_id', 'id');
    }
    
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'lesson_id', 'id');
    }
}
