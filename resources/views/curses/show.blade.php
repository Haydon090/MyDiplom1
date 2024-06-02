@extends('layout')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h2>{{ $curse->Name }}</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 bg-secondary p-3">
        <div class="form-group">
            <strong>Description:</strong>
            {{ $curse->Description }}
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <h4>Lessons</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curse->lessions as $index => $lession)
                    @php
                        $isCompleted = $lession->userProgress->where('user_id', auth()->id())->where('completed', true)->count() > 0;
                    @endphp
                    <tr>
                        <td>{{ $lession->Number }}</td>
                        <td>{{ $lession->Name }}</td>
                        <td>{{ $lession->Description }}</td>
                        <td>
                            @if($isCompleted)
                                <span class="badge badge-success">Завершен</span>
                            @else
                                <span class="badge badge-secondary">Не завершен</span>
                            @endif
                        </td>
                        <td>
                            <div class="row">

                                    @if (auth()->user()->role_id == 1)
                                        @if ($index > 0)
                                            <form action="{{ route('curses.lessions.move-up', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm mb-1 mr-1">
                                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($index < count($curse->lessions) - 1)
                                            <form action="{{ route('curses.lessions.move-down', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm mr-1">
                                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif




                                    @if (auth()->user()->role_id == 1)
                                    <a class="btn btn-xs btn-primary mb-2 btn-sm" href="{{ route('tests.show', $lession) }}">Test</a>
                                        <a href="{{ route('lessions.update', ['curseId' => $curse->id, 'lession' => $lession]) }}" class="btn btn-xs btn-primary mb-2 btn-sm mr-1 ml-1">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('lessions.show', ['lession' => $lession]) }}" class="btn btn-xs btn-primary mb-2 btn-sm mr-1">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    @if(auth()->user()->role_id == 2)
                                        <a href="{{ route('tests.take', $lession->test) }}" class="btn btn-xs btn-primary mb-2 btn-sm mr-1">Тест</a>


                                    @endif
                                    <div class="width-100"></div>
                                    @if (auth()->user()->role_id == 1)
                                    <form action="{{ route('curses.lessions.destroy', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@php
    $userRatedCourse = $curse->ratings()->where('user_id', auth()->id())->exists();
@endphp

@if (auth()->user()->role_id == 2 && $curse->lessions->every(function ($lession) use ($user) {
    return $lession->isCompletedByUser($user->id);
}) && !$userRatedCourse)
<div class="row mt-4">
    <div class="col-md-12">
        <h4>Rate this Course</h4>
        <form action="{{ route('curses.rate', ['curseId' => $curse->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="rating">Your Rating:</label>
                <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
    </div>
</div>
@endif

@if (auth()->user()->role_id == 1)
    <a class="btn btn-success mb-3" href="{{ route('lessions.create', $curse->id) }}">Create New Lesson</a>
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
@endsection
