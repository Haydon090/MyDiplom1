@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $test->title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('tests.submit', $test) }}" method="POST">
                        @csrf
                        @foreach($questions as $question)
                            <div class="mb-4">
                                <h5>{{ $question->question_text }}</h5>
                                @foreach($question->answers as $index => $answer)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $index }}" id="question-{{ $question->id }}-answer-{{ $index }}">
                                        <label class="form-check-label" for="question-{{ $question->id }}-answer-{{ $index }}">
                                            {{ $answer }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Отправить тест</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
