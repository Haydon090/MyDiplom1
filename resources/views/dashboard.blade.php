@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 mt-2 mb-2">
            <div class="pull-left">
                <h2>Courses</h2>
            </div>
            <div class="pull-right">
                @if (auth()->user()->role_id == 1)
                    <a class="btn btn-success mb-3" href="{{ route('curses.create') }}">Create New Course</a>
                @endif
                <a class="btn btn-success mb-3" href="{{ route('statistics') }}">Show Statistics</a>
            </div>
            <form action="{{ route('curses.index') }}" method="GET" class="input-group mb-3">
                <select name="sort_by" class="form-control" onchange="this.form.submit()">
                    <option value="completions" {{ request('sort_by', 'completions') == 'completions' ? 'selected' : '' }}>Сортировка по количеству прохождений</option>
                    <option value="ratings" {{ request('sort_by') == 'ratings' ? 'selected' : '' }}>Сортировка по рейтингу</option>
                </select>
            </form>

            <form action="{{ route('curses.index') }}" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Поиск по названию или описанию" name="query" value="{{ request('query') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Найти</button>
                </div>
            </form>


        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($curses->isNotEmpty())
    <div class="row">
        @foreach ($curses as $curse)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $curse->Name }}</h5>
                        <p class="card-text">{{ $curse->Description }}</p>
                        <div>
                        @foreach ($curse->tags->take(3) as $tag)
                            {{ $tag->Name }}@if (!$loop->last), @endif
                        @endforeach
                        @if ($curse->tags->count() > 3)
                            ...
                        @endif
                        </div>
                        <a href="{{ route('curses.show', $curse->id) }}" class="btn btn-info mb-2">посмотреть</a>
                        @if (auth()->user()->role_id == 1)
                            <a href="{{ route('curses.edit', $curse->id) }}" class="btn btn-primary mb-2">редактировать</a>
                            <form action="{{ route('curses.destroy', $curse) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-2">удалить</button>
                            </form>
                        @endif
                        <a href="{{ route('curses.add', $curse->id) }}" class="btn btn-primary mb-2">добавить на аккаунт</a>

                        @if ($curse->hasUserRated(auth()->id()))
                            <p class="text-secondary">пройден</p>
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <p>
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <span style="display: inline-block;">{{ $curse->ratings_count }}</span>
                                    <i class="fa fa-star" aria-hidden="true" style="margin-left: 10px;"></i>
                                    <span style="display: inline-block;">{{ round($curse->ratings_avg, 2) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p>По вашему запросу ничего не найдено.</p>
    @endif
@endsection
