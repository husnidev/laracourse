<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseModule As Module;
use App\Models\Lesson;

class CourseModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function isAdmin(): bool
    {
       return Auth::user()->role == 'admin';
    }

    public function index(Request $request)
    {
        $course_id = $request->id;
        $course = Course::where('id', $course_id)
            ->when(!$this->isAdmin(), function ($query) {
        $query->where('teacher_id', auth()->id());
        })->firstOrFail();
        $modules = $course->modules;
        $lessons = [];
        foreach ($modules as $module) {
            $lessons = Lesson::find()->where('module_id', $module['id']);
        }
        return view('course-modules.index', compact('course', 'modules', 'lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
