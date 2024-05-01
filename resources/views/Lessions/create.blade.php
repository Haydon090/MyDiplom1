@extends('layout')

@section('content')

    <form action="{{ route('curses.lessions.store', $id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="title" class="form-control" required> <!-- Исправлено -->
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Lesson</button>
        </form>

@endsection
