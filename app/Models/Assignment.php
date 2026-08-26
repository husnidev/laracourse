<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('assignments')]
class Assignment extends Model
{
    public $timestamps = false;
    public $fillable = ['lesson_id', 'title', 'description', 'due_date', 'max_score'];

}
