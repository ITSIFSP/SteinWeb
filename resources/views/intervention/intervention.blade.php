@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/loading.css')}}">
@endsection
@section('content')

    <div class="container-fluid">
        <div class="table-responsive">
            <table id="interventionTable" class="table table-striped table-hover">
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
                                                    <button class="btn btn-danger" id="btn-approve" title="Status" data-value="true" data-intervention_id="{{ $key }}" onclick="updateInterventionStatus(this)"><i class="fa fa-thumbs-down"></i></button>
                                                @else
                                                    <button class="btn btn-success" id="btn-approve" title="Status" data-value="false" data-intervention_id="{{ $key }}" onclick="updateInterventionStatus(this)"><i class="fa fa-thumbs-up"></i></button>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" id="btn-change" title="Trocar" data-intervention_id="{{ $key }}" onclick="changeIntervention(this)"><i class="fa fa-refresh" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-danger" id="btn-remove" title="Excluir" data-intervention_id="{{ $key }}" onclick="deleteIntervention(this)"><i class="fa fa-trash"></i></button>
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

    <!-- Modal SendEmail Intervention-->
    <div class="modal" tabindex="-1" id="sendEmailModal" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Enviar Emails de Interdições</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


              <table id="otherTable" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>
                                {{-- <input type="checkbox" name="mainCheckEmails" class="mainCheckEmails"> --}}
                            </th>
                            <th>Email</th>
                            <th>Organização</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr value="{{ $user->id }}">
                                <td>
                                    {{-- <input type="checkbox" name="checkEmails[]" value="{{ $user->id }}" data-userid="{{ $user->id }}" class="checkEmails"> --}}

                                </td>
                                <td><input type="hidden" name="" value="{{ $user->id }}">{{ $user->email }}</td>
                                <td>{{  $user->name }}<input type="hidden" id="interdictionKey" name="" value=""></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cancelar</button>
                <button type="button" id="btnSendMail" class="btn btn-primary" onclick="sendEmail()">Enviar</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal modal-loading">
        <div class="loading"></div>
    </div>


@endsection

@section('js')

<script src="{{ asset('assets/js/intervention.js') }}"></script>
<link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function() {

    });

    // $(".table").DataTable();
    $("#interventionTable").DataTable({
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

    function changeIntervention(e){
        var id = $(e).attr('data-intervention_id');
        var key = {
            id : id
        };
        Swal.fire({
            title: 'Você tem certeza?',
            text: "As ruas da interdição serão trocadas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim!'
        }).then((result) => {
            if (result.value) {
                $(".modal-loading").modal("show");
               axios.post("{{ route('change.streets') }}", key)
                .then((response) => {
                    $(".modal-loading").modal("toggle");
                    Swal.fire(
                    'Trocado!',
                    'As ruas foram alternadas com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })
                })
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
                        if(status == false || status == 'false'){
                            document.getElementById('interdictionKey').value = id
                            $("#sendEmailModal").modal('show');
                        }
                        else{
                            location.reload();
                        }
                    })
                }
            }
        });
    }

    var tabelaTeste = $("#otherTable").DataTable({
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
        "bPaginate": false,
        'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
    })


    function sendEmail(){
        try {

            $("#btnSendMail").prop('disabled', true);

            var tabela = document.getElementById("otherTable");
            var linhas = tabela.getElementsByTagName('tr');

            var checkboxes = $(".dt-checkboxes");
            var index = [];

            for(let i in checkboxes){
                if(checkboxes[i]['checked'] == true){
                    index.push(i);				//-- traz o indice checado
                }
            }

            var userIds = [];

            for(let j in linhas){
                if(j > 0){
                    for(let k in index){
                        if(index[k] == (j-1)){
                            // content.push(linhas[j]["innerText"]);
                            userIds.push({id: linhas[j]["attributes"]["value"]["value"]});
                        }
                    }
                }
            }

            var interventionKey = document.getElementById('interdictionKey').value;
            var organization = "{{ Auth::user()->name }}";
            // console.log(organization);
            // console.log("Intervention key: ", interventionKey);
            //$(".sendEmailModal").modal("close");

            Swal.fire(
                    'Enviando...',
                    'Os emails estão sendo enviados!',
                    'success'
                    ).then(result => {
                        if(result.value){
                            axios.post('{{ route('sendEmail') }}',[
                            userIds, interventionKey, organization
                        ])
                            location.reload();
                        }
            });

            // .then(result => {
            //     if(result.status){
            //         //$(".modal-loading").modal("toggle");

            //     }
            //     else{
            //         location.reload();
            //     }
            //  });
        } catch (error) {
            location.reload();
            console.log(error)
        }
    }
</script>

@endsection
