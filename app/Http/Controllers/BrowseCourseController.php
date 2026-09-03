<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Enrollment;

class BrowseCourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search') ?? '';
        $category_filter = $request->input('category') ?? '';
        $query = DB::table('courses')
            ->select('courses.*', 'categories.name as category_name', 'users.name as teacher_name',
            DB::raw('(SELECT COUNT(*) FROM enrollments WHERE course_id = courses.id) as enrollment_count'))
            ->join('categories', 'courses.category_id', '=', 'categories.id')
            ->join('users', 'courses.teacher_id', '=', 'users.id')
            ->where('courses.status', 'published');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('courses.title', 'like', '%' . $search . '%')
                    ->orWhere('courses.description', 'like', '%' . $search . '%');
            });
        }

        if (!empty($category_filter)) {
            $query->where('categories.id', $category_filter);
        }

        $courses = $query->paginate(10);
        $categories = DB::table('categories')->get();
        $enrolled_ids = auth()->check() ? DB::table('enrollments')
                ->where('student_id', auth()->id())
                ->pluck('course_id')
                ->toArray() : [];

        return view('browse-courses.index', compact('courses', 'categories', 'search', 'category_filter', 'enrolled_ids'));
    }
    
    public function enroll(Request $request)
    {
        $course_id = $request->input('course_id');
        $student_id = auth()->id();

        // Check if the student is already endrolled
        $already_enrolled = Enrollment::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->exists();

        if (!$already_enrolled){
            Enrollment::create([
                'course_id' => $course_id,
                'student_id' => $student_id,
            ]);
        } else {
            return back()->with('error', 'Anda sudah terdaftar di kursus ini.');
        }

        return back()->with('success', 'Berhasil mendaftar kursus.');
    }
}
