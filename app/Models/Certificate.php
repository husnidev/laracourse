<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('certificates')]
class Certificate extends Model
{
    public $timestamps = false;
    public $fillable = ['course_id', 'student_id', 'certificate_no', 'issued_date', 'file'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
