@extends('layouts.admin')

@section('titulo')
    Tareas
@endsection

@section('navbar')
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Marcosland</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"><a class="nav-link" href="dashboard"><i ></i><span>Dashboard</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link active" href="tareas"><i class="fas fa-book"></i><span>Tareas</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="usuarios"><i class="fas fa-users"></i><span>Usuarios</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="{{route('logout')}}" id="linkLogout"><i ></i><span>Logout</span></a>
                    <form id="formLogout" action="{{route('logout')}}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
        </div>
    </nav>
@endsection

@section('contenido')
    <h3 class="text-dark mb-4">Tarea</h3>
    <div class="card shadow">
        <div class="card-header py-3">
            <a class="btn btn-primary" href="{{ route('tareas.create') }}">
                <i class="fa fa-plus"></i> Agregar Registro
            </a>
        </div>

        <div class="card-body">

            <!-- Checks if the change was made through a variable sent in the next (or last) screen -->
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Éxito
                    </h5>
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('failure'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Error
                    </h5>
                    {{ Session::get('failure') }}
                </div>
            @endif

            <form >
                <div class="row">
                    <div class="col-md-4">
                        <select name="filtro" class="form-control" data-toggle="dropdown" aria-expanded="false">
                            <option value="fecha" class="dropdown-item" role="presentation">Filtrar por fecha</option>
                            <option value="estado" class="dropdown-item" role="presentation">Filtrar por estado de la tarea</option>
                            <option value="usuario" class="dropdown-item" role="presentation">Filtrar por usuario</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" aria-controls="dataTable" placeholder="Buscar...">
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table dataTable my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Usuario</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tareas as $tarea)
                        <tr>
                            <td>{{ $tarea -> id}}</td>
                            <td>{{ $tarea -> id_user}}</td>
                            <td>{{ $tarea -> estado}}</td>
                            <td>{{ $tarea -> fecha}}</td>
                            <td>{{ $tarea -> descripcion}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- Show -->
                                    <a class="btn btn-primary" type="button" href="{{ route('tareas.show', $tarea -> id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a class="btn btn-success" type="button" href="{{ route('tareas.edit', $tarea -> id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <!-- Delete -->
                                    <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $tarea -> id }})" data-target="#delete-modal" class="btn btn-danger delete-modal-btn">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td><strong>ID Usuario</strong></td>
                            <td><strong>Estado</strong></td>
                            <td><strong>Fecha</strong></td>
                            <td><strong>Descripción</strong></td>
                            <td><strong>Acciones</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                        Mostrando del 1 al 10
                    </p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form id="deleteForm" method="post" action="{{ route('tareas.destroy', $tarea  -> id ?? '') }}" >
        @csrf
        @method('DELETE')
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">¿Seguro de que desea eliminar el registro?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        No será posible recuperar la información de dicho registro
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Descartar
                        </button>

                        <button type="submit" class="btn btn-primary" name="delete_noticia" onclick="formSubmit()">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <script>
        function doClickLinkLogout(e) {
          e.preventDefault();
          $("#formLogout").submit();
        }
        $(function() {
          $("#linkLogout").click(doClickLinkLogout);
        });
    </script>

    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("tareas.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
            $("#modal-body").innerHTML("En caso de borrar la noticia no habrá manera de recuperarla.")
        }
    </script>
@endsection