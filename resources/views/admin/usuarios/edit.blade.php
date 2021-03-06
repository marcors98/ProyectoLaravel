<!--cambiar usertype por user_type
Cambiar instalaciones por tareas
borrar fotos
cambiar ubicacion por descripcion-->
<!-- This page will extend from (or retrieve all of the html from) the file views/layouts/admin.blade.php -->
@extends('layouts.admin')

@section('titulo')
    Usuarios
@endsection

@section('navbar')
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Duventus</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="dashboard"><i ></i><span>Dashboard</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="tareas"><i class="fas fa-book"></i><span>Tareas</span></a></li>
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
    <h3 class="text-dark mb-4">Usuarios</h3>
    <div class="card shadow">
        <div class="card-header py-3">
                Registro #{{ $usuarios -> id}}
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

            <form method="POST" enctype="multipart/form-data" action="{{route('usuarios.update', $usuarios -> id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>
                        Tipo de Usuario
                    </label>

                    <select name="user_type" class="form-control" data-toggle="dropdown" aria-expanded="false">
                        <option value="{{ $usuarios -> usertype }}" class="dropdown-item" role="presentation">{{ $usuarios -> user_type }}</option>
                        
                        @if($usuarios -> usertype == "Administrador")
                        <option value="Usuario" class="dropdown-item" role="presentation">Usuario</option>
                        @else
                        <option value="Administrador" class="dropdown-item" role="presentation">Administrador</option>
                        @endif

                    </select>
                </div>

                <div class="form-group">
                    <label>
                        Nombre
                    </label>

                    <input type="text" name="name" class="form-control" value="{{ $usuarios -> name }}"></input>
                </div>
                
                
                <div class="form-group">
                    <label>
                        Correo
                    </label>

                    <input type="text" name="email" class="form-control" value="{{ $usuarios -> email }}"></input>
                </div>
                
                <div class="form-group">
                    <input type="hidden" name="password" class="form-control" value="{{ $usuarios -> password }}"></input>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-primary">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <a href="{{ route('usuarios.index') }}">
        <br>← Volver al Dashboard
    </a>
    
    <script>
        function doClickLinkLogout(e) {
          e.preventDefault();
          $("#formLogout").submit();
        }
        $(function() {
          $("#linkLogout").click(doClickLinkLogout);
        });
    </script>
@endsection