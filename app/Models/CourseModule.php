<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('course_modules')]
class CourseModule extends Model
{
    public $timestamps = false;
    public $fillable = ['course_id', 'title', 'description', 'sequence'];
}
