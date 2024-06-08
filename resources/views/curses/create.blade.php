@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-2 mb-2">
            <div class="pull-left">
                <h2>Add New Curse</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard') }}">Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('curses.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="Name" class="form-control" placeholder="Name" value="{{ old('Name') }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="Description" placeholder="Description">{{ old('Description') }}</textarea>
                </div>
            </div>


<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tags:</strong><br>
                    @foreach($tags as $tag)
                        <label class="checkbox-inline"><input type="checkbox" name="tags[]" value="{{ $tag->id }}"> {{ $tag->Name }}</label>
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <div class="mt-3">
        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tagName">Create Your Own Tag:</label>
                <input type="text" class="form-control" id="tagName" name="Name" placeholder="Enter Tag Name">
            </div>
            <button type="submit" class="btn btn-primary">Create Tag</button>
        </form>
    </div>
@endsection
