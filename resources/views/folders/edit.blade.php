@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Folders</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('folders.index') }}">Folders</a></li>
                        <li class="breadcrumb-item active">Edit Folder</li>
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
                            <h3 class="card-title">Edit Folder</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('folders.update', $folder->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $folder->name }}" />
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
                                                    id="inlineCheckbox{{ $permission->id }}"
                                                    value="{{ $permission->id }}"
                                                    {{ $folder->permissions->contains('id', $permission->id) ? 'checked' : '' }} />
                                                <label class="form-check-label"
                                                    for="inlineCheckbox{{ $permission->id }}">{{ $permission->name }}</label>
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
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
