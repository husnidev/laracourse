<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        // role admin bisa melihat semua kursus, sedangkan role teacher hanya bisa melihat kursus yang dibuatnya sendiri
        if(Auth::user()->role == 'admin') {
            $courses = Course::all();
        } else {
            $courses = Course::where('teacher_id', Auth::id())->get(); // hanya kursus yang dibuat oleh teacher yang sedang login
        }
        $categories = Category::all();
        return view('courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $courses = Course::all();
        $categories = Category::all();
        return view('courses.create', compact('courses', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'level' => 'nullable|string|in:beginner,intermediate,advanced',
            'duration' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,published,archived',
        ]);

        $course = new Course();
        $course->teacher_id = Auth::id();
        $course->category_id = $request->category_id;
        $course->title = $request->title;
        $course->slug = Str::slug($request->title) . '-' . Str::random(5);
        $course->description = $request->description;
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        $course->level = $request->level ?? 'beginner';
        $course->duration = $request->duration ?? 0;
        $course->price = $request->price ?? 0;
        $course->status = $request->status ?? 'draft';
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil dibuat.');
    }

    public function edit($id)
    {
        // jika role user adalah teacher, maka hanya bisa mengedit kursus yang dibuatnya sendiri
        if(Auth::user()->role == 'teacher') {
            $course = Course::where('id', $id)->where('teacher_id', Auth::id())->firstOrFail();
            $courses = Course::where('teacher_id', Auth::id())->get(); // hanya kursus yang dibuat oleh teacher yang sedang login
            $categories = Category::all();
            return view('courses.edit', compact('course', 'courses', 'categories'));
        } else {
            $course = Course::findOrFail($id);
            $courses = Course::all();
            $categories = Category::all();
            return view('courses.index', compact('course', 'courses', 'categories'));
        }
        $categories = Category::all();

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'level' => 'nullable|string|in:beginner,intermediate,advanced',
            'duration' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,published,archived',
        ]);

        $course = Course::findOrFail($id);
        $course->category_id = $request->category_id;
        $course->title = $request->title;
        $course->slug = Str::slug($request->title) . '-' . Str::random(5);
        $course->description = $request->description;
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        $course->level = $request->level ?? 'beginner';
        $course->duration = $request->duration ?? 0;
        $course->price = $request->price ?? 0;
        $course->status = $request->status ?? 'draft';
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        // jika role user adalah teacher, maka hanya bisa menghapus kursus yang dibuatnya sendiri
        if(Auth::user()->role == 'teacher' && $course->teacher_id != Auth::id()) {
            $course->where('teacher_id', Auth::id())->delete();
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus kursus ini.');
        } else {
            return back()->with('success', 'Kursus berhasil dihapus.');
        }

    }
}
