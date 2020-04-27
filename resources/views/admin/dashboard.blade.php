@extends('layouts.admin')

@section('titulo')
    Dashboard
@endsection

@section('usuario')
    Nombre de Usuario
@endsection

@section('navbar')
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>MarcosLand</span></div>
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
    
@endsection