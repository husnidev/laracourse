<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseModule;
use App\Models\Lesson;
use App\Models\LessonCompletion;

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

    public function detail($course_id)
    {
        // check enrollment
        $enrollment = DB::table('enrollments as e')
            ->join('courses as c', 'e.course_id', '=', 'c.id')
            ->leftJoin('categories as cat', 'c.category_id', '=', 'cat.id')
            ->leftJoin('users as u', 'c.teacher_id', '=', 'u.id')
            ->where('e.course_id', $course_id)
            ->where('e.student_id', Auth::id())
            ->select(
                'e.id as enrollment_id',
                'e.*',
                'e.status as enrollment_status',
                'e.progress as enrollment_progress',
                'c.*',
                'cat.name as category_name',
                'u.name as teacher_name'
            )
            ->first();

        if(!$enrollment){
            return redirect()->route('my-courses.index')->with('error', 'Anda belum terdaftar di kursus ini. Silakan daftar terlebih dahulu untuk mengakses konten kursus.');
        }

        $modules = CourseModule::where('course_id', $course_id)->orderBy('sequence')->get();
        $lessons = [];
        foreach ($modules as $module) {
            $lessons = Lesson::where('module_id', $module['id'])->get();
        }

        $completed_lesson_ids = LessonCompletion::where('student_id', Auth::id())
            ->pluck('lesson_id')
            ->all();

        return view('my-courses.detail', compact('enrollment', 'modules', 'lessons', 'completed_lesson_ids'));
    }

    public function completeLesson(Request $request, $lesson_id)
    {
        $isCompleted = LessonCompletion::where('lesson_id', $lesson_id)
            ->where('student_id', Auth::id())
            ->exists();

        if(!$isCompleted){
            LessonCompletion::create([
                'lesson_id' => $lesson_id,
                'student_id' => Auth::id(),
                'completed_at' => now()
            ]);
        }

        //  calculate progress
        $totalLessons = Lesson::where('module_id', function($query) use ($lesson_id) {
            $query->select('module_id')
                ->from('lessons')
                ->where('id', $lesson_id);
        })->count();

        $completedLessons = LessonCompletion::where('student_id', Auth::id())
            ->whereIn('lesson_id', function($query) use ($lesson_id){
                $query->select('id')
                    ->from('lessons')
                    ->where('module_id', function($query) use ($lesson_id) {
                        $query->select('module_id')
                            ->from('lessons')
                            ->where('id', $lesson_id);
                    });
        })->count();

        $newProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0;

        // update enrollment progress
        DB::table('enrollments')
            ->where('student_id', Auth::id())
            ->whereIn('course_id', function($query) use ($lesson_id){
                $query->select('course_id')
                    ->from('course_modules')
                    ->whereIn('id', function($query) use ($lesson_id) {
                        $query->select('module_id')
                            ->from('lessons')
                            ->where('id', $lesson_id);
                    });
            })
            ->update(['progress' => $newProgress]);

        if($newProgress >= 100){
            // check if certificate already exists
            $isCertificateExists = DB::table('certificates')
                ->where('student_id', Auth::id())
                ->whereIn('course_id', function($query) use ($lesson_id){
                    $query->select('course_id')
                        ->from('course_modules')
                        ->whereIn('id', function($query) use ($lesson_id){
                            $query->select('module_id')
                            ->from('lessons')
                            ->where('id', $lesson_id);
                        });
                })
                ->exists();

            if(!$isCertificateExists){
                // update enrollment status to completed
                DB::table('enrollments')
                    ->where('student_id', Auth::id())
                    ->whereIn('course_id', function($query) use ($lesson_id){
                        $query->select('course_id')
                            ->from('course_modules')
                            ->whereIn('id', function($query) use ($lesson_id){
                                $query->select('module_id')
                                ->from('lessons')
                                ->where('id', $lesson_id);
                            });
                    })
                    ->update(['status' => 'completed']);
                $certno = 'CERT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
                // generate certificate
                DB::table('certificates')->insert([
                    'student_id' => Auth::id(),
                    'course_id' => DB::table('course_modules')
                        ->whereIn('id', function($query) use ($lesson_id){
                            $query->select('module_id')
                            ->from('lessons')
                            ->where('id', $lesson_id);
                        })
                        ->value('course_id'),
                    'certificate_no' => $certno,
                    'issued_date' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pelajaran telah ditandai sebagai selesai.');
    }
}
