@extends('layouts.master')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="h-100 fixed" style="padding: 20px;">
    <div class="row h-100">
      <div class="col-3">
        <ul class="nav nav-tabs" id="muTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="intervention-tab" data-toggle="tab" href="#intervention" role="tab" aria-controls="home" aria-selected="true">Cadastro</a>
            </li>
            <li class="nav-item">
                {{-- <a class="nav-link" id="filter-tab" data-toggle="tab" href="#filter" role="tab" aria-controls="profile" aria-selected="false">Filtragem</a> --}}
            </li>
        </ul>
        <div class="tab-content" id="interventions-content">
          {{-- CADASTRO --}}
            <div class="tab-pane fade show active" id="intervention" role="tabpanel" aria-labelledby="intervention-tab" style="margin-top: 15px;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"> <i class="fa fa-map-marker" aria-hidden="true"></i> </span>
                  </div>
                  <input type="text" class="form-control" id="origin" placeholder="Ponto de Partida" aria-label="origin" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"> <i class="fa fa-map-marker" aria-hidden="true"></i> </span>
                  </div>
                  <input type="text" class="form-control" id="destiny" placeholder="Ponto de Destino" aria-label="destination" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="description" placeholder="Descrição">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="datetimes" id="date"/>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="authority" placeholder="" disabled value="{{ Auth::user()->authority }}">
                </div>
                <div class="form-group">
                  <button class="btn btn-primary form-control" id="btn-intervention" name="btn-intervention">Adicionar Interdição</button>
                </div>
            </div>
            {{-- CADASTRO --}}
            {{-- FILTRO --}}
            <div class="tab-pane fade" id="filter" role="tabpanel" aria-labelledby="filter-tab">
                Lorem, ipsum. Lorem, ipsum.
            </div>
            {{-- FILTRO --}}
        </div>
      </div>
      <div class="col-9">
        <div id="map" class="teste">
            {{-- ver como aumentar o tamanho do mapa --}}
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')

{{-- Firebase --}}
<script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/live/3.1/firebase.js"></script>
{{-- Locals --}}
<script src="{{ asset('assets/js/firebase.js') }}"></script>
<script src="{{ asset('assets/js/map.js') }}"></script>



{{-- Maps --}}
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiQpZjuO1K2Y9PfZLAsYqqDVIhVhxtU7s&callback=initMap"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

$(document).ready(function () {

  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      "format": 'DD/MM/YYYY hh:mm A',
      "separator": '~',
      "applyLabel": 'Confirmar',
      "cancelLabel": 'Cancelar',
      "daysOfWeek": [
        "Dom",
        "Seg",
        "Ter",
        "Qua",
        "Qui",
        "Sex",
        "Sab"
    ],
      "monthNames": [
        "Jan",
        "Fev",
        "Mar",
        "Abr",
        "Mai",
        "Jun",
        "Jul",
        "Ago",
        "Set",
        "Out",
        "Nov",
        "Dez"
      ],
      "firstDay" : 0
    }
  });

  var origem = [];
  var destino = [];
  var origin, destiny, description, date, permission, user;

  $("#btn-intervention").click(function(){

    origin = $('#origin').val();
    destiny = $('#destiny').val();
    description = $('#description').val();
    date = $('input[name="datetimes"]').val();
    permission = $('#authority').val();
    user = "{{ Auth::user()->name }}";

    if(origin == '' || destiny == '' || description == ''){
      alert("Preencha todos os campos para cadastrar a indertição!");
      return;
    }

    addIntervention(origin, destiny, description, date, permission, user);
  });

  //Verifica se o usuário esta inativo, se tiver ele não pode adicionar interdição
  var userStatus = '{{ Auth::user()->status }}';
  if(userStatus == false || userStatus == 0){
    $('#btn-intervention').attr("disabled", true);
  }

});


</script>
@endsection

