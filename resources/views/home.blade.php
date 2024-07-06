@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline btn-success" href="{{ route('field.create') }}">Create New Field</a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fields as $key => $field)
                                <tr id="field_{{ $field->id }}">
                                    <td class="text-capitalize">{{ $field->label }}</td>
                                    <td class="text-capitalize">{{ $field->type }}</td>
                                    <td>
                                        <a href="{{ route('field.edit', $field->id) }}"
                                            class="btn btn-warning me-3">Edit</a>

                                        <button type="button" class="btn btn-outline btn-danger action-delete"
                                            onclick="confirmDelete({{ $field->id }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">No fields to list.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(fieldId) {
            if (confirm('Are you sure you want to delete this field?')) {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "/destroy-field/" + fieldId,
                    type: "DELETE",
                    data: {
                        _token: _token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                        $('#field_' + fieldId).remove();
                    }
                });
            }
        }
    </script>
@endsection
