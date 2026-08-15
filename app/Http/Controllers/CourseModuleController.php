<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseModule As Module;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;

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
            $lessons = Lesson::where('module_id', $module['id'])->get();
        }
        $categories = Category::all();
        return view('course-modules.index', compact('course', 'modules', 'lessons', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $module = new Module();
        $course_id = $request->course_id ?? '';
        $maxSeq = Module::where('course_id', $course_id)->max('sequence');
        $module->course_id = $course_id;
        $module->title = $request->title;
        $module->description = $request->description;
        $module->sequence = $maxSeq + 1;

        $module->save();

        return back()->with('success', 'Module berhasil ditambahkan!');
       
    
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
