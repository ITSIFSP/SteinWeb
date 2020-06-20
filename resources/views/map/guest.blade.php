@extends('layouts.guestMap')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')


        <div id="map" >
            {{-- ver como aumentar o tamanho do mapa --}}
        </div>


@endsection

@section('js')

{{-- Firebase --}}
<script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/live/3.1/firebase.js"></script>
{{-- Locals --}}
<script src="{{ asset('assets/js/firebase.js') }}"></script>
<script src="{{ asset('assets/js/guest.js') }}"></script>



{{-- Maps --}}
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiQpZjuO1K2Y9PfZLAsYqqDVIhVhxtU7s&callback=initMap"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

</script>
@endsection

