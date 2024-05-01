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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curse->lessions as $index => $lession)
                        <tr>
                            <td>{{ $lession->Number }}</td>
                            <td>{{ $lession->Name }}</td>
                            <td>{{ $lession->Description }}</td>
                            <td>
                                <div class="row">

                                <div class="col">
                                @if ($index > 0)
                                    <form action="{{ route('curses.lessions.move-up', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm mb-1"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
                                    </form>
                                @endif
                                @if ($index < count($curse->lessions) - 1)
                                    <form action="{{ route('curses.lessions.move-down', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                                    </form>
                                @endif</div>
                                <form action="{{ route('curses.lessions.destroy', ['curseId' => $curse->id, 'lessionId' => $lession->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs btn-sm mb-1"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                                <form >
                                    <a href="{{ route('lessions.update', ['curseId' => $curse->id, 'lession' => $lession]) }}" class="btn btn-xs btn-primary mb-2 btn-sm" method="GET"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </form>
                                <form >
                                    <a href="{{ route('lessions.show', ['lession' => $lession]) }}" class="btn btn-xs btn-primary mb-2 btn-sm" method="GET"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </form>
                            </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a class="btn btn-success mb-3" href="{{ route('lessions.create', $curse->id) }}">Create New Lesson</a>
@endsection
