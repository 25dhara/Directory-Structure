@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Folder List</h3>
                                <div class="float-right">
                                    <a class="btn btn-block btn-sm btn-success mb-2"
                                        href="{{ route('folders.create') }}">Create New Folder</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Folder Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Created By</th>
                                                
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($filteredFolders as $folder)
                                                <tr>
                                                    <td>{{ $folder->id }}</td>
                                                    <td>{{ $folder->name }}</td>
                                                    <td>{{ $folder->creator->name }}</td>

                                                    <td>
                                                        @if ($folder->permissions->contains('name', 'read'))
                                                        <i class="fas fa-eye"></i>
                                                    @endif
                                                    @if ($folder->permissions->contains('name', 'write'))
                                                        <i class="fas fa-pen"></i>
                                                    @endif
                                                        @if ($folder->permissions->contains('name', 'update'))
                                                            <a href="{{ route('folders.edit', $folder->id) }}"
                                                                class="fas fa-edit"></a>
                                                        @endif
                                                        @if ($folder->permissions->contains('name', 'delete'))
                                                            <a href="#"
                                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $folder->id }}').submit();"><i
                                                                    class="fas fa-trash text-danger"></i></a>

                                                            <form id="delete-form-{{ $folder->id }}"
                                                                action="{{ route('folders.destroy', $folder->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
