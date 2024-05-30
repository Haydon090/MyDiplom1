@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Результаты теста:</h2>
                </div>
                <div class="card-body">
                    <p>Тест пройден на {{ $score }}%</p>
                    <p>Правильных ответов {{ $correctAnswersCount }} из {{ $totalQuestions }}</p>
                    <a href="{{ route('curses.show', $curse->id) }}" class="btn btn-primary">К урокам</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
