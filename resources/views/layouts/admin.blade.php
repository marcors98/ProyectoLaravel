<!DOCTYPE html>
<html style="height:100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        @yield('titulo')
    </title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top" style="height:100%;">
    <div id="wrapper">
        
        @if(Auth::user() -> user_type == "Administrador")
        
            @yield('navbar')
        
        @endif

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small">
                                            {{Auth::user() -> name}}
                                        </span>
                                        <img class="border rounded-circle img-profile" src="/storage/usuario/{{ Auth::user()->foto }}" />
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                        <a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" role="presentation" href="{{route('logout')}}" id="linkLogout2"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                        <form id="formLogout2" action="{{route('logout')}}" method="POST">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                @if(Auth::user() -> user_type == "Usuario")
                    <div class="container-fluid" style="height:100%;">
                        <p class="text-center">
                            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                            No eres un administrador
                            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                            
                        </p>
                    </div>
                @endif
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2020</span></div>
                </div>
            </footer>
        </div>

        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="/js/theme.js"></script>

    <script>
        function doClickLinkLogout(e) {
          e.preventDefault();
          $("#formLogout2").submit();
        }
        $(function() {
          $("#linkLogout2").click(doClickLinkLogout);
        });
    </script>
</body>

</html>