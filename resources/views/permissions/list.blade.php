@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Permissions</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permissions</a></li>
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
                                <h3 class="card-title">Permissions list</h3>
                                <div class="float-right">
                                    <a class="btn btn-block btn-sm btn-success" href="{{ route('permission.create') }}">
                                        Create New Permission</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Permissions Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->id }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->description }}</td>
                                                    <td>
                                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                                            class="fas fa-edit"></a>
                                                        <a href="#" class="delete-link"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $permission->id }}').submit();">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $permission->id }}"
                                                            action="{{ route('permission.destroy', $permission->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
