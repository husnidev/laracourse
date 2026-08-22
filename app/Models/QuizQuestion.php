<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('quiz_questions')]
class QuizQuestion extends Model
{
    public $timestamps = false;
    public $fillable = ['quiz_id', 'question', 'type', 'score'];
}
