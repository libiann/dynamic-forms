@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Edit Field</h2>
                </div>
                <div class="float-right mb-4 mt-3">
                    <a class="btn btn-outline btn-primary" href="{{ route('home') }}">Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Whoops!</strong> There were some problems with your input.<br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('field.update', $field->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="form-group">
                        <label for="label">Label <span class="text-danger">*</span>:</label>
                        <input type="text" name="label" id="label" placeholder="Label" class="form-control"
                            value="{{ $field->label }}" required>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span>:</label>
                        <select name="type" id="field_type" class="form-control" required>
                            <option value="">Select a Type</option>
                            <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="select" {{ $field->type == 'select' ? 'selected' : '' }}>Select</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-8 mb-4" id="selectOptions"
                    style="{{ $field->type == 'select' ? 'display: block;' : 'display: none;' }}">
                    <div class="form-group">
                        <label for="options">Options:</label>
                        <div id="optionFields">
                            @if ($field->type == 'select')
                                @foreach (json_decode($field->options) as $option)
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control"
                                            value="{{ $option }}">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger delete-option">Delete</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="addMore" class="btn btn-success">Add More</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-outline btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#field_type').change(function() {
                const selectOptionsDiv = $('#selectOptions');
                if ($(this).val() === 'select') {
                    selectOptionsDiv.show();
                } else {
                    selectOptionsDiv.hide();
                }
            });

            $('#addMore').click(function() {
                $('#optionFields').append(`
                <div class="input-group mb-2">
                    <input type="text" name="options[]" class="form-control">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger delete-option">Delete</button>
                    </div>
                </div>
            `);
            });

            $(document).on('click', '.delete-option', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
@endsection
