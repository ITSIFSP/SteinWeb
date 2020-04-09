<!-- aqui vai ser a master page do site -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITS - Intervention System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
    .green_dot {
        height: 10px;
        width: 10px;
        background-color: #90FF33;
        border-radius: 50%;
        display: inline-block;
    }
    .red_dot {
        height: 10px;
        width: 10px;
        background-color: #EB2038;
        border-radius: 50%;
        display: inline-block;
    }
    .custom{
        font-size: 18px;
    }
    </style>
    @yield('css')
</head>
<body>

    <header>
        <!-- Navbar Menu -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light custom">
            <a class="navbar-brand" href="{{ route('map') }}" style="margin-left: 5px;"><i class="fa fa-globe" aria-hidden="true"><span style="margin-right: 5px;"></span>ITS</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active" style="margin-right: 10px;">
                        <a class="nav-link" href="{{ url('/map') }}"><i class="fa fa-map-marker"> <span style="margin-right: 5px;"></span>Mapa <span class="sr-only">(current)</span> </i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"><span style="margin-right: 5px;"></span>Cadastros</i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('user') }}"><i class="fa fa-users" aria-hidden="true"></i><span style="margin-right: 5px;"></span>Usuários</a>
                        <a class="dropdown-item" href="{{ route('intervention') }}"><i class="fa fa-exclamation-triangle" aria-hidden="true"><span style="margin-right: 5px;"></span>Interdições</i></a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle-o" aria-hidden="true"><span style="margin-right: 8px;"></span>{{ Auth::user()->name }}</i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item hide" id="btn-leave"><i class="fa fa-sign-out" aria-hidden="true"><span style="margin-right: 5px;"></span>Sair</i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Navbar Menu -->
    </header>

    @yield('content')



    <footer>
    <!-- fazer algo contato com email ou etc -->
    </footer>
    
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-database.js"></script>
    <script src="http://www.gstatic.com/firebasejs/live/3.1/firebase.js"></script>

    {{-- Locals --}}
    <script src="{{ asset('assets/js/firebase.js') }}"></script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    
    <script>

        $("#btn-leave").click(function () {
            axios.post("{{ url('/user-logout') }}")
            .then(result => {
                window.location.href = '{{url('/')}}'
            });
        });                
    </script>

    @yield('js')

</body>
</html>