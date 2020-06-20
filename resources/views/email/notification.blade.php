<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <p>
        Aos setores responsáveis:
    </p>

    <p>Foi aprovado por <strong>{{ $organization }}</strong> a seguinte interdição:</p>

    <p>Ruas: <strong>{{ $data['origin']['street'] }}</strong> e a <strong>{{ $data['destination']['street'] }}</strong>
        <br>
    Período: <strong>{{$data['beginDate']}}</strong> até <strong>{{ $data['endDate'] }}</strong></p>

    <p>Descrição: <strong>{{ $data['description'] }}</strong>

</body>
</html>
