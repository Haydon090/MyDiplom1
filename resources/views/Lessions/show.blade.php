@extends('layout')

@section('content')
    <div class="container">
        <button id="addMaterialBtn" class="btn btn-primary">Add Material</button>

        <div id="materialMenu" class="mt-3" style="display: none;">
            <div class="form-group">
                <label for="materialType">Material Type:</label>
                <select id="materialType" class="form-control">
                    <option value="text">Text</option>
                    <option value="link">Link</option>
                    <option value="video">Video Link</option>
                    <option value="image">Image</option>
                </select>
            </div>
            <div id="inputFields"></div>
            <button id="submitMaterialBtn" class="btn btn-success mt-3">Submit</button>
        </div>
    </div>

    <script src="{{ asset('js/material.js') }}"></script>
@endsection
