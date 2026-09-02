<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class StudentController extends Controller
{
    public function isAdmin(): bool
    {
       return Auth::user()->role == 'admin';
    }

    public function index()
    {
        $students = Enrollment::query()
            ->select(["users.*", "enrollments.enrolled_at", "enrollments.progress", "enrollments.status as enrollment_status", "courses.title as course_title"])
            ->join('users', 'enrollments.student_id', '=', 'users.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->when(!$this->isAdmin(), function ($query){
                $query->where('courses.teacher_id', auth()->id());
            })
            ->orderByDesc('enrollments.enrolled_at')
            ->get();

        return view('students.index', compact('students'));
    }
}
