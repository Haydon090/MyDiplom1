@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-2 mb-2">
            <div class="pull-left">
                <h2>Courses</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-3" href="{{ route('curses.create') }}">Create New Course</a>
            </div>

            <form action="{{ route('curses.index') }}" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Поиск по названию или описанию" name="query">
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
                        <p class="card-text">Price: {{ $curse->Price }}</p>
                        <a href="{{ route('curses.show',$curse->id) }}" class="btn btn-info mb-2">посмотреть</a>
                        <a href="{{ route('curses.edit',$curse->id) }}" class="btn btn-primary mb-2">редактировать</a>
                        <a href="{{ route('curses.add',$curse->id) }}" class="btn btn-primary">добавить на аккаунт</a>
                        <form action="{{ route('curses.destroy',$curse->id) }}" method="DELETE">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mt-3">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p>По вашему запросу ничего не найдено.</p>
    @endif
@endsection
