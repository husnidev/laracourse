<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyCourseController extends Controller
{
    public function index(Request $request)
    {
        $myCourses = DB::table('enrollments')
        ->select(
            'courses.*',
            'enrollments.progress',
            'enrollments.status as enrollment_status',
            'enrollments.enrolled_at',
            'categories.name as category_name',
            'users.name as teacher_name',
            DB::raw('(SELECT COUNT(*) FROM course_modules WHERE course_id = courses.id) as module_count')
        )
        ->join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->join('categories', 'courses.category_id', '=', 'categories.id')
        ->join('users', 'courses.teacher_id', '=', 'users.id')
        ->where('enrollments.student_id', auth()->id())
        ->orderBy('enrollments.enrolled_at', 'desc')
        ->get();

        return view('my-courses.index', compact('myCourses'));
    }
}
