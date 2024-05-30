@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Create Test for Lesson: {{ $lession->title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('tests.store', $lession) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Test Title:</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Create Test</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
