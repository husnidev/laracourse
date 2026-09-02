<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizQuestion as Question;
use App\Models\QuestionOption as Option;
use App\Models\Quiz;

class ManageQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($quiz_id)
    {
        $questions = Question::where('quiz_id', $quiz_id)->get();
        $quiz = Quiz::query()
                ->select([
                    'quizzes.*',
                    'lessons.title as lesson_title',
                    'courses.id as course_id',
                    'courses.title as course_title'
                ])
                ->join('lessons', 'quizzes.lesson_id', '=', 'lessons.id')
                ->join('course_modules','lessons.module_id', '=', 'course_modules.id')
                ->join('courses', 'course_modules.course_id', '=', 'courses.id')
                ->where('quizzes.id', $quiz_id)
                ->where('courses.teacher_id', auth()->id())
                ->first();

        return view('quizzes.index', compact('questions', 'quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->type;
        $question = Question::create([
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'type' => $type,
            'score' => $request->score
        ]);

        if($type !== 'essay') {
            $options = $_POST['options'] ?? [];
            $correct = $_POST['correct_option'] ?? 0;
            foreach ($options as $i => $option_text) {
                if (trim($option_text) === '') continue;
                $is_correct = ($i == $correct) ? 1 : 0;

                $option = Option::create([
                    'question_id' => $question->id,
                    'option_text' => $option_text,
                    'is_correct' => $is_correct
                ]);
            }

        }

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $question_id = $request->question_id;
        $question = Question::find($question_id);
        $option = Option::where('question_id', $question_id)->first();

        if($option){
            $question->options()->delete();
            // atau
            // Option::where('question_id', $question_id)->delete();
        }

        if(!$question){
            return back()->with('error', 'id soal : '.$question_id.' tidak ditemukan!');
        }

        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus!');
    }
}
