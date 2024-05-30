<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Test $test)
    {
        $test->title = 'Тест ' . $test->lession->Number . ' урока';
        return view('questions.create', compact('test'));
    }

    public function store(Request $request, Test $test)
    {
        $question = $test->questions()->create([
            'question_text' => $request->input('question_text'),
            'answers' => $request->input('answers'),
            'correct_answers' => $request->input('correct_answers')
        ]);

        $lession = $test->lession;
        return redirect()->route('tests.show', $lession)->with('success', 'Вопрос успешно создан.');
    }

    public function destroy(Question $question)
    {
        $test = $question->test;
        $lession = $test->lession;
        $question->delete();
        return redirect()->route('tests.show', $lession)->with('success', 'Вопрос успешно удален.');
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
{
    $request->validate([
        'question_text' => 'required|string',
        'answers' => 'required|array|min:2',
        'answers.*' => 'required|string',
        'correct_answers' => 'required|array|min:1',
    ]);

    $question->update([
        'question_text' => $request->input('question_text'),
        'answers' => $request->input('answers'),
        'correct_answers' => $request->input('correct_answers'),
    ]);

    $test = $question->test;
    $lession = $test->lession;
    return redirect()->route('tests.show', $lession)->with('success', 'Вопрос успешно обновлен.');
}

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }
}
