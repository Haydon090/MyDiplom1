<?php

namespace App\Http\Controllers;
use App\Models\Lession;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create(Lession $lession)
    {
        return view('tests.create', compact('lession'));
    }

    public function store(Request $request, Lession $lession)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $test = new Test();
        $test->title = $request->title;
        $test->lession_id = $lession->id;
        $test->save();
        return redirect()->route('questions.create', $test)->with('success', 'Test created successfully');
    }
    public function show(Lession $lession)
    {
        $test = Test::where('lession_id', $lession->id)->first();
        if ($test) {
            $test->title = 'Тест ' . $lession->Number . ' урока';
            $questions = Question::where('test_id', $test->id)->get();
            return view('tests.show', compact('test', 'questions'));
        } else {

            return redirect()->back()->with('error', 'Test not found for this lesson');
        }
    }
    public function take(Test $test)
    {
        $questions = $test->questions;
        $test->title = 'Тест ' . $test->lession->Number . ' урока';
        return view('tests.take', compact('test', 'questions'));
    }

    public function submit(Request $request, Test $test)
    {
        $userAnswers = $request->input('answers');
        $correctAnswersCount = 0;

        foreach ($test->questions as $question) {
            $correctAnswers = $question->correct_answers;
            $userAnswer = isset($userAnswers[$question->id]) ? $userAnswers[$question->id] : [];

            // Проверяем, что пользователь выбрал все правильные ответы и только их
            if (!array_diff($correctAnswers, $userAnswer) && !array_diff($userAnswer, $correctAnswers)) {
                $correctAnswersCount++;
            }
        }

        $totalQuestions = $test->questions->count();
        $score = ($correctAnswersCount / $totalQuestions) * 100;
        $lession = $test->lession;
        $curse = $lession->curse;

        return view('tests.result', compact('score', 'correctAnswersCount', 'totalQuestions', 'curse'));
    }
}
