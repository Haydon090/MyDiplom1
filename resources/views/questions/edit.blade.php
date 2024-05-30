@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Редактировать вопрос к тесту: {{ $question->test->title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.update', $question) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="question_text">Текст вопроса:</label>
                            <textarea name="question_text" id="question_text" class="form-control" rows="3" required>{{ $question->question_text }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="answers">Ответы:</label>
                            @foreach ($question->answers as $index => $answer)
                                <input type="text" name="answers[]" class="form-control mb-2" value="{{ $answer }}" placeholder="Ответ {{ $index + 1 }}" required>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="correct_answers">Правильные ответы:</label>
                            @foreach ($question->answers as $index => $answer)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="correct_answers[]" value="{{ $index }}" id="correct_answer_{{ $index }}" {{ in_array($index, $question->correct_answers) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="correct_answer_{{ $index }}">
                                        Ответ {{ $index + 1 }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-success">Обновить вопрос</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
