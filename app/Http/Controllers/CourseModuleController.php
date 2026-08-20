<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseModule As Module;
use App\Models\Lesson;
use App\Models\Category;

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $module = Module::find($id);
        $module->title = $request->title;
        $module->description = $request->description;
        $module->update();

        return back()->with('success', 'Module berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        // hanya role teacher yang bisa menghapus module
        if(Auth::user()->role !='teacher'){
            return back()->with('error', 'Hanya teacher yang bisa menghapus module.');
        }

        $module->delete();

        return back()->with('success', 'Modul berhasil dihapus.');
    }

    public function create_lesson(Request $request)
    {
        $lesson = new Lesson();
        $module_id = $request->module_id;
        $maxSeq = Lesson::where('module_id', $module_id)->max('sequence');
        $lesson->module_id = $request->module_id;
        $lesson->title = $request->title;
        $lesson->content = $request->content;
        $lesson->video_url = $request->video_url;
        $lesson->sequence = $maxSeq + 1;
        $lesson->save();

        return back()->with('success', 'Lesson berhasil ditambahkan!');
    }

    public function update_lesson(Request $request)
    {
        $lesson_id = $request->lesson_id;
        $lesson = Lesson::find($lesson_id);
        $lesson->title = $request->title;
        $lesson->content = $request->content;
        $lesson->video_url = $request->video_url;
        $lesson->duration = $request->duration;
        $lesson->update();

        return back()->with('success', 'Lesson berhasil diupdate!');
    } 

    public function delete_lesson(Request $request)
    {
        $lesson_id = $request->lesson_id;
        $lesson = Lesson::find($lesson_id);

        if(!$lesson){
            return back()->with('error', 'Id lesson = '.$lesson_id.' tidak ditemukan!');
        }

        $lesson->delete();

        return back()->with('success', 'Lesson berhasil dihapus!');
    }
}
