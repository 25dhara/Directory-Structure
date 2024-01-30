@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit File</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('files.index') }}">Files</a></li>
                        <li class="breadcrumb-item active">Edit File</li>
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
                            <h3 class="card-title">Edit File</h3>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('files.update', $file->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label for="folder_id">Folder<span class="text-danger">*</span></label>
                                    <select name="folder_id" class="form-control @error('folder_id') is-invalid @enderror">
                                        @foreach ($folders as $folder)
                                            <option value="{{ $folder->id }}"
                                                {{ $folder->id == $file->folder_id ? 'selected' : '' }}>
                                                {{ $folder->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('folder_id')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $file->name) }}" />
                                    @error('name')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="display_name">Display Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror"
                                        id="display_name" name="display_name"
                                        value="{{ old('display_name', $file->display_name) }}" />
                                    @error('display_name')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file">File<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="file" type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file">
                                            <label class="custom-file-label" for="file" id="file-label">{{ $file->name }}</label>
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                


                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update File</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
        const fileInput = document.getElementById('file');

        // Listen for change event on file input
        fileInput.addEventListener('change', function() {
            // Get the selected file name
            const fileName = fileInput.files[0].name;

            // Display the selected file name
             document.getElementById('file-label').innerText = fileName;
        });
    </script>
@endpush
