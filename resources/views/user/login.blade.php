<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITS - Intervention System</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
 
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-6 hidden-md-down" id="bimg">
                {{-- IMG screen --}}
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="row justify-content-center align-items-center h-100">
                    <div>
                        <h1 style="margin-bottom: 30px;"><i class="fa fa-globe"></i><span style="margin-right: 10px;"></span>Sistema de Intervenções</h1>
                    </div>
                    <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i> </span>
                                </div>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" aria-label="email" aria-describedby="basic-addon1">
                            </div>           
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"> <i class="fa fa-lock" aria-hidden="true"></i> </span>
                                </div>
                                <input type="password"  name="password" class="form-control" id="password" placeholder="Senha" aria-label="password" aria-describedby="basic-addon1">
                            </div> 
                            <a href="{{ route('password.recovery') }}">Esqueceu a senha?</a>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control" id="btn-login">
                                    Login
                                </button>
                                
                            </div>
                        <div class="form-group">
                            <button  class="btn btn-light form-control" id="btn-guest" name="btn-guest">Guest</button>
                        </div>
                    </div>
                </div>
            </div>          
          </div>
        </div>
      </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>

        $("#btn-login").click(function (){
            var email = $("#email").val();
            var password = $("#password").val();

            if(email == '' || password == ''){
                alert("Preencha login e senha!");
                return;
            }
            axios.post("{{ route('user.check.login') }}", {
                email, password
            }).then(response =>{
                window.location.href = "{{ url('/map') }}"
            }).catch(error => {
                alert('Erro ao logar no sistema!'); 
            });
        });

        $("#btn-guest").click(function (){
            window.location.href = "{{ url('/guest') }}"
        });
    </script>
</body>
</html>


