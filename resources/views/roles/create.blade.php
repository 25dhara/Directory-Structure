@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Create Role</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('roles.store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Assign Permission</label>
                                        <div>
                                            @foreach ($permissions as $permission)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="permissions[]" type="checkbox"
                                                        id="inlineCheckbox1" value="{{ $permission->id }}" />
                                                    <label class="form-check-label"
                                                        for="inlineCheckbox1">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        @error('name')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Assign Permission Section -->
        {{-- <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Assign Permission</h3>
                            </div>

                            <div class="container">
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="permissions[]" type="checkbox"
                                            id="inlineCheckbox1" value="{{ $permission->id }}" />
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        </form>
    </div>
@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#name', 'description').on('input', function() {
                removeErrorMessages($(this));
            });

            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');

                errorElement remove();

                inputField.removeClass('is-invalid');
            }
        });
    </script>
@endpush
