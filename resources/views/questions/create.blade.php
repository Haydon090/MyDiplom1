@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Добавьте вопрос на тест: {{ $test->title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.store', $test) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="question_text">Текст вопроса:</label>
                            <textarea name="question_text" id="question_text" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="answers">Ответы:</label>
                            <input type="text" name="answers[]" class="form-control mb-2" placeholder="Ответ 1" required>
                            <input type="text" name="answers[]" class="form-control mb-2" placeholder="Ответ 2" required>
                            <input type="text" name="answers[]" class="form-control mb-2" placeholder="Ответ 3" required>
                            <input type="text" name="answers[]" class="form-control mb-2" placeholder="Ответ 4" required>
                        </div>
                        <div class="form-group">
                            <label for="correct_answers">Правильные ответы:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="correct_answers[]" value="0" id="correct_answer_0">
                                <label class="form-check-label" for="correct_answer_0">Ответ 1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="correct_answers[]" value="1" id="correct_answer_1">
                                <label class="form-check-label" for="correct_answer_1">Ответ 2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="correct_answers[]" value="2" id="correct_answer_2">
                                <label class="form-check-label" for="correct_answer_2">Ответ 3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="correct_answers[]" value="3" id="correct_answer_3">
                                <label class="form-check-label" for="correct_answer_3">Ответ 4</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
