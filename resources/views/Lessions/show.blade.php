@extends('layout')

@section('content')<div class="container">
    <ul>
        @foreach($materials as $material)
            <li>
                @if($material->Type === 'text')
                <div>
                    {!! $material->Content !!}
                </div>
                @elseif ($material->Type === 'image')
                    <div>
                        <img src="{{ asset($material->File_path) }}" class="mt-3 mb-3" style="max-width: 100%; height: auto" width="900" height="300">
                    </div>
                @elseif ($material->Type === 'video')
                    {!! str_replace(['width="560"', 'height="315"'], ['width="900"', 'height="500"'], $material->Url) !!}
                @endif
                <form action="{{ route('materials.destroy', ['id' => $material->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs btn-sm mb-1"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>
            </li>
        @endforeach
    </ul>
</div>


<div class="container">
    <button id="addMaterialBtn" class="btn btn-primary">Add Material</button>

    <div id="materialMenu" class="mt-3" style="display: none;">
        <form id="materialForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lessionId" value="{{ $lession->id }}">
            <input type="hidden" id="quillContent" name="quillContent">
            <div class="form-group">
                <label for="materialType">Material Type:</label>
                <select id="materialType" class="form-control" name="materialType">
                    <option value="text">Text</option>

                    <option value="video">Video Link</option>
                    <option value="image">Image</option>
                </select>
            </div>
            <div id="inputFields"></div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
    $('#materialForm').on('submit', function(event) {
    event.preventDefault();

    // Получаем содержимое Quill-редактора
    var htmlContent = $('.ql-editor').html();

    // Устанавливаем это содержимое в скрытое поле формы
    $('#quillContent').val(htmlContent);
    });
jQuery(document).ready(function($) {
    $('#addMaterialBtn').on('click', function() {
        $('#materialMenu').show();
    });

    $('#materialType').on('change', function() {
        var materialType = $(this).val();
        var inputFieldsDiv = $('#inputFields');

        inputFieldsDiv.empty();

        if (materialType === 'text') {
            var editorDiv = $('<div>').attr('id', 'editor-container');
            inputFieldsDiv.append(editorDiv);

            var quill = new Quill('#editor-container', {
                theme: 'snow'
            });
        } else if (materialType === 'image') {



            var fileInput = $('<input>').attr('type', 'file').addClass('form-control-file').attr('name', 'image');
            inputFieldsDiv.append(fileInput);
        }else if(materialType ==='video'){
            var urlInput = $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'url').attr('placeholder', 'Enter YouTube URL');
            inputFieldsDiv.append(urlInput);
        }
    });

    $('#materialForm').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "/materials",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                location.reload();
            },
        });
    });
});
</script>
@endsection
