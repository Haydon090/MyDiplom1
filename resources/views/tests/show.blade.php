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
                    <a href="{{ route('questions.create', $test) }}" class="btn btn-primary mb-3">Добавить вопрос</a>
                    @if($questions->isNotEmpty())
                        <ul class="list-group">
                            @foreach($questions as $question)
                                <li class="list-group-item">
                                    <strong>{{ $question->question_text }}</strong>
                                    <ul class="list-group mt-2">
                                        @foreach($question->answers as $index => $answer)
                                            <li class="list-group-item">
                                                {{ $answer }}
                                                @if(in_array($index, $question->correct_answers))
                                                    <span class="badge badge-success">верно</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-primary btn-sm mt-2"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('questions.destroy', $question) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mt-2"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Нет вопросов</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('tests.take', $test) }}" class="btn btn-primary width-100%">Пройти</a>
        </div>
    </div>
</div>
@endsection
