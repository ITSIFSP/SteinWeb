@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Ponto Inicial</th>
                        <th scope="col">Ponto Final</th>
                        <th scope="col">Organização</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data Início</th>
                        <th scope="col">Data Fim</th>
                    @if (Auth::user()->authority == 'Administrador')
                        <th scope="col">Aprovação</th>
                        <th scope="col">Excluir</th>
                    @endif
                       
                    </tr>
                </thead>
                <tbody>
                    {{-- Aqui vai o foreach --}}
                    @if (isset($interventions))
                            @foreach ($interventions as $its)
                            <tr>
                                <td>{{ $loop->iteration }} <input type="hidden" name="key" id="key_id"></td>
                                <td>{{ $its['description'] }}</td>
                                <td>{{ $its['origin']['street'] }}</td>
                                <td>{{ $its['destination']['street'] }}</td>
                                <td>{{ $its['organization'] }}</td>
                                @if ($its['status'] == true)
                                    <td><span class="green_dot"></span> Ativo</td>
                                @else
                                    <td><span class="red_dot"></span> Inativo</td>
                                @endif
                                <td>{{ $its['beginDate'] }}</td>
                                <td>{{ $its['endDate'] }}</td>

                                @foreach ($interventions as $key => $value)
                                    @if($loop->parent->iteration == $loop->iteration)
                                        @if (Auth::user()->authority == 'Administrador')
                                            <td>
                                                @if ($its['status'] == true)
                                                    <button class="btn btn-danger" id="btn-approve" data-value="true" data-intervention_id="{{ $key }}" onclick="updateInterventionStatus(this)"><i class="fa fa-thumbs-down"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER-->
                                                @else
                                                    <button class="btn btn-success" id="btn-approve" data-value="false" data-intervention_id="{{ $key }}" onclick="updateInterventionStatus(this)"><i class="fa fa-thumbs-up"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER-->
                                                @endif
                                            </td> 
                                            <td>
                                                <button class="btn btn-danger" id="btn-remove" data-intervention_id="{{ $key }}" onclick="deleteIntervention(this)"><i class="fa fa-trash"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER-->
                                            </td>        
                                        @endif                                                                      
                                    @endif         
                                @endforeach                                
                            </tr>
                        @endforeach 
                    @endif            
                </tbody>
            </table>
        </div>
    </div>



@endsection

@section('js')

<script src="{{ asset('assets/js/intervention.js') }}"></script>

<script>
    $(document).ready(function() {
        var users = [];
        users = getUsers();
        // console.log(users)
    });

    var user = firebase.database().ref("users");
    user.once("value", function(snapshot) {
        var data = [];
        data = snapshot.val();
        console.log(data);
    });

    // $(".table").DataTable();
    $(".table").DataTable({
        "bJQueryUI": true,
        "oLanguage": {
            "sProcessing":   "Processando...",
            "sLengthMenu":   "Mostrar _MENU_ registros",
            "sZeroRecords":  "Não foram encontrados resultados",
            "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
            "sInfoFiltered": "",
            "sInfoPostFix":  "",
            "sSearch":       "Buscar:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Primeiro",
                "sPrevious": "Anterior",
                "sNext":     "Seguinte",
                "sLast":     "Último"
            }
        },        
    })

    function deleteIntervention(e){
        var id = $(e).attr('data-intervention_id');
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Não será possível voltar atrás!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim!'
        }).then((result) => {
            if (result.value) {
                if(deleteInterventionFromFirebase(id)){
                    Swal.fire(
                    'Excluído',
                    'A interdição foi excluída com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })                    
                }             
            }
        })
    }
    
    
    function updateInterventionStatus(e){
        var id = $(e).attr('data-intervention_id');
        var status = $(e).attr('data-value');
        Swal.fire({
            title: 'Deseja atualizar o status da interdição?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim!'
        }).then((result) => {
            if (result.value) {
                if(updateInterventionStatusFirebase(id, status)){
                    Swal.fire(
                    'Atualizado',
                    'A interdição foi atalizada com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })                    
                }             
            }
        })
    }
    // $("#btn-approve").click(function(e){
        
    // });

   
        
</script>

@endsection