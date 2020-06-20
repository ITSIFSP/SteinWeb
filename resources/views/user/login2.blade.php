<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITS - Intervention System</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
</head>
<body background="{{ asset('assets/img/background.jpg') }}">
    <div class="align-item-center justify-content-center row" style="margin-top: 250px;">
        <div class="row mx-auto">
           
            <div class="col-6">         
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <img src="{{ asset('assets/img/google_marker.png') }}" alt="map-marker" style="height: 100px; padding: 10px;">                
                        </div>
                        <div class="col-8">
                            <h1 style="padding: 30px;">Sistema de Intervenções</h1>
                        </div>
                    </div>
                </div> 
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i> </span>
                    </div>
                    <input type="text" class="form-control" id="destiny" placeholder="Usuário" aria-label="destination" aria-describedby="basic-addon1">
                </div>           
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"> <i class="fa fa-lock" aria-hidden="true"></i> </span>
                    </div>
                    <input type="text" class="form-control" id="destiny" placeholder="Senha" aria-label="destination" aria-describedby="basic-addon1">
                </div> 
                <div class="form-group">
                    <button class="btn btn-primary form-control" id="btn-interdiction" name="btn-interdiction">Login</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-light form-control" id="btn-interdiction" name="btn-interdiction">Guest</button>
                </div>
            </div>
        </div>
    </div>

    


    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    
</body>
</html>
