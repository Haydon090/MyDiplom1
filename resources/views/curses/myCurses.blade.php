@extends('layout')

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="row mt-10">
@foreach ($curses as $curse)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $curse->Name }}</h5>
                <p class="card-text">{{ $curse->Description }}</p>
                <p class="card-text">Price: {{ $curse->Price }}</p>
                <a href="{{ route('curses.show',$curse->id) }}" class="btn btn-info">Show</a>
                <a href="{{ route('curses.edit',$curse->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('curses.add',$curse->id) }}" class="btn btn-primary">Add</a>
                <form action="{{ route('curses.destroy',$curse->id) }}" method="DELETE">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-10">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>


@endsection
