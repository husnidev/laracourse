<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $totalStudents = User::where('role', 'student')->count();
            $totalTeachers = user::where('role', 'teacher')->count();
            $totalCourses = Course::count();
            $publishedCourses = Course::where('status', 'published')->count();
            $totalEnrollments = Enrollment::count();
            $topCourses = Course::select('courses.title', DB::raw('COUNT(enrollments.id) as enrollments_count'))
                ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
                ->groupBy('courses.id', 'courses.title')
                ->orderByDesc('enrollments_count')
                ->limit(5)
                ->get();
            $recentEnrollments = DB::table('enrollments as e')
                ->select('u.id', 'u.name', 'c.id', 'c.title')
                ->join('users as u', 'e.student_id', '=', 'u.id')
                ->join('courses as c', 'e.course_id', '=', 'c.id')
                ->orderByDesc('e.enrolled_at')
                ->limit(5)
                ->get();
            $recentUsers = User::whereIn('role', ['student', 'teacher'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            return view('dashboard', compact('totalStudents', 'totalTeachers', 'totalCourses', 'publishedCourses', 'totalEnrollments', 'topCourses', 'recentEnrollments', 'recentUsers'));
        } elseif(Auth::user()->role == 'teacher') {
            $totalCourses = Course::where('teacher_id', auth()->id())->count();
            $totalStudents = DB::table('enrollments as e')
                ->join('courses as c', 'e.course_id', '=', 'c.id')
                ->where('c.teacher_id', auth()->id())
                ->distinct()
                ->count('e.student_id');
            $publishedCourses = Course::where(['teacher_id' => auth()->id(), 'status' => 'published'])->count();
            $topCourses = Course::where('teacher_id', auth()->id())
                ->withCount([
                    'enrollments as enrollment_count'
                ])
                ->orderByDesc('enrollment_count')
                ->limit(5)
                ->get(['id', 'title']);
            $recentEnrollments = DB::table('enrollments as e')
                ->select('u.id', 'u.name', 'c.id', 'c.title')
                ->join('users as u', 'e.student_id', '=', 'u.id')
                ->join('courses as c', 'e.course_id', '=', 'c.id')
                ->orderByDesc('e.enrolled_at')
                ->limit(5)
                ->get();

            return view('dashboard', compact('totalCourses', 'totalStudents', 'publishedCourses', 'topCourses', 'recentEnrollments'));
        } else {
            $enrolledCourses = Enrollment::where('student_id', auth()->id())->count();
            $completedCourses = Enrollment::where(['student_id' => auth()->id(), 'status' => 'completed'])->count();
            $certificates = Certificate::where('student_id', auth()->id())->count();
            $avgProgress = round(Enrollment::where('student_id', auth()->id())->avg('progress') ?? 0);
            $recentCourses = Enrollment::with('course')
                ->where('student_id', auth()->id())
                ->orderByDesc('enrolled_at')
                ->limit(5)
                ->get();

            return view('dashboard', compact('enrolledCourses', 'completedCourses', 'certificates', 'avgProgress', 'recentCourses'));
        }

    }
}
