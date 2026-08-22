<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('question_options')]
class QuestionOption extends Model
{
    public $timestamps = false;
    public $fillable = ['question_id', 'option_text', 'is_correct'];
}
