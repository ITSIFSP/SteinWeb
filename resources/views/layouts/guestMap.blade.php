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
            <a class="navbar-brand" href=" {{url('/')}} " style="margin-left: 5px;"><i class="fa fa-globe" aria-hidden="true"><span style="margin-right: 5px;"></span>ITS</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                </span>
            </button>
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
    

    @yield('js')

</body>
</html>