@extends('layouts.master')

@section('content')

    @if (Auth::user()->authority == 'Administrador')
        <div class="container-fluid" style="padding: 15px;">
            <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal">Novo</button> <!--Confirmar se o usuário é admin para mostrar o botão-->
        </div>
    @endif
    

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        <th scope="col">CNPJ</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Status</th>
                        @if (Auth::user()->authority == 'Administrador')    <!--Permissão para atualizar o status dos usuários-->
                            <th scope="col">Status</th>
                            <th scope="col">Editar</th>
                        @endif                        
                        
                        {{-- <th scope="col">Excluir</th> --}}
                    </tr>
                </thead>
                <tbody>
                    {{-- Aqui vai o foreach --}}
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['cnpj'] }}</td>
                            <td>{{ $user['authority'] }}</td>
                            @if ($user['status'] == true)
                                <td><span class="green_dot"></span> Ativo</td>
                            @else
                                <td><span class="red_dot"></span> Inativo</td>
                            @endif

                            @if (Auth::user()->authority == 'Administrador')
                                
                                <td>
                                    @if ($user['status'] == true)
                                        <button class="btn btn-danger" id="btn-status" data-value="true" data-user_id="{{ $user->id }}" onclick="updateUserStatus(this)"><i class="fa fa-lock"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER e status-->
                                    @else
                                        <button class="btn btn-success" id="btn-status" data-value="false" data-user_id="{{ $user->id }}" onclick="updateUserStatus(this)"><i class="fa fa-unlock-alt"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER-->
                                    @endif
                                </td>
                                @if (Auth::user()->authority == 'Administrador')
                                    <td>
                                        <button class="btn btn-primary" title="Editar" data-user_id="{{ $user->id }}" style="margin-right: 5px;" onclick="getUser(this)" id="btn-status"><i class="fa fa-pencil"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER e status-->
                                        <button class="btn btn-danger" title="Excluir" data-user_id="{{ $user->id }}" onclick="removeUser(this)" id="btn-remove"><i class="fa fa-trash"></i></button><!--FAZER VERIFICAÇÃO DE ADMIN OU USER-->
                                    </td>    
                                @endif
                            @endif
                        </tr>
                    @endforeach                
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Create-->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalTitle">Cadastro de Usuários</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="nome">Nome:<span style="color:red;">*</span></label>
                            <input type="text" required class="form-control" id="name" name="nome">
                        </div>
                        <div class="form-group">
                            <label for="cnpj">CNPJ:<span style="color:red;">*</span></label>
                            <input type="text" required class="form-control" id="cnpj" name="cnpj">
                        </div>
                        <div class="form-group">
                            <label for="email:">Login:<span style="color:red;">*</span></label>
                            <input type="email" required class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:<span style="color:red;">*</span></label>
                            <div class="input-group" id="show_hide_password">
                            <input class="form-control" required type="password" name="password" id="password">
                            <div class="input-group-addon">
                                <span class="input-group-text"><a href="" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            </div>
                            </div>
                        </div>         
                        <div class="form-group">
                            <label for="authority">Privilégios:<span style="color:red;">*</span></label>
                            <select class="form-control" name="authority" id="authority">
                                <option value="Administrador">Administrador</option>
                                <option value="Usuário">Usuário</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" onclick="createUser()">Confirmar</button>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalTitle">Atualiar Usuários</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idUpdate" id="idUpdate" value=""> 
                <div class="form-group">
                    <label for="nameUpdate">Nome:<span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" id="nameUpdate" name="nameUpdate" value="">
                </div>
                <div class="form-group">
                    <label for="cnpjUpdate">CNPJ:<span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" id="cnpjUpdate" name="cnpjUpdate" value="">
                </div>
                <div class="form-group">
                    <label for="emailUpdate">Email:<span style="color:red;">*</span></label>
                    <input type="email" required class="form-control" id="emailUpdate" name="emailUpdate" value="">
                </div>     
                <div class="form-group">
                    <label for="authorityUpdate">Privilégios:<span style="color:red;">*</span></label>
                    <select class="form-control" name="authorityUpdate" id="authorityUpdate">
                        <option value="Administrador">Administrador</option>
                        <option value="Usuário">Usuário</option>                                
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="updateUser()">Confirmar</button>
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('js')

<script src="{{ asset('assets/js/user.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#registerModal').on('shown.bs.modal');
    });

    //Mostra senha no form 
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });

    //Tradução da datatable
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

    function createUser(){
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var status = true; //true
        var cnpj = $("#cnpj").val();
        var authority = $("#authority").val();

        if(name != '' && email != '' && password != '' && status != '' && cnpj != '' && authority != ''){
            axios.post("{{ url('user-register') }}", {
                name, email, password, status, cnpj, authority
            })
            .then((result) => {
                Swal.fire(
                    'Criado',
                    'O usuário foi criado com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })  
            })
            .catch((errorr) => {
                alert('Erro ao criar o usuário, contate o administrador do sistema!');
            });   
        }
        else{
            alert("Preencha todos os campos!");
        }

    }


    function updateUserStatus(e){
        var id = $(e).attr('data-user_id');

        Swal.fire({
            title: 'Deseja atualizar o status do usuário?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim!'
        })
        .then((result) => {
            if(result.value){
                axios.post("{{ url('/user-updateStatus') }}", {
                    status, id
                })
                .then((result) => {
                    Swal.fire(
                        'Atualizado',
                        'O status foi atalizado com sucesso!',
                        'success'
                        ).then((result) => {
                            if(result.value){
                                location.reload();
                            }
                        })  
                })
                .catch((error) => {
                    alert("Erro ao atualizar o usuário, contate o usuário do sistema!");
                })
            }
        })
    }
    


    //Atualiza o usuário
    function updateUser(){

        var id = $("#idUpdate").val();
        var name = $("#nameUpdate").val();
        var email = $("#emailUpdate").val();
        var cnpj = $("#cnpjUpdate").val();
        var authority = $("#authorityUpdate").val();

        Swal.fire({
            title: 'Deseja atualizar os dados do usuário?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim!'
        }).then((result) => {
            if(result.value){
                axios.post("{{ url('/user-update') }}", {
                    id, name, email, password, cnpj, authority
                })
                .then((result) => {
                    Swal.fire(
                    'Atualizado',
                    'O usuário foi atualizado com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })          
                })
                .catch(() => {
                    alert("Erro ao atualizar o usuário, contate o usuário do sistema!")
                }) 
            }   
        })
        

        

    }


    //Traz os dados do Usuário selecionado
    async function getUser(e){
        var id = $(e).attr('data-user_id');

        const {data} = await axios.post("{{ url('/user-update-get') }}", {
            id
        })
        .catch((error) => {
            alert("Não foi possível localizar o usuário, contate o usuário do sistema!")
        })

        console.log(data);

        //Preenche o modal com os dados do banco
        $("#idUpdate").val(id);
        $("#nameUpdate").val(data.name);
        $("#emailUpdate").val(data.email);
        $("#passwordUpdate").val(data.password);
        $("#cnpjUpdate").val(data.cnpj);
        $("#authorityUpdate").val(data.authority);

        //Mostra o modal preenchido
        $("#updateModal").modal("show");
    }

    //Remove o usuário do banco de dados
    function removeUser(e){
        var id = $(e).attr('data-user_id');

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
                axios.post("{{ url('/user-delete') }}", {
                    id
                })
                .then((result) => {
                    Swal.fire(
                    'Excluído',
                    'O usuário foi excluído com sucesso!',
                    'success'
                    ).then((result) => {
                        if(result.value){
                            location.reload();
                        }
                    })          
                })
                .catch(() => {
                    alert("Erro ao excluir o usuário, contate o usuário do sistema!")
                })       
            }
        })
    }
    
    // // //Altera o status do usuário (ativo/inativo)
    // // function updateUserStatus(e){
    // //     var id = $(e).attr('data-user_id');
    // //     var status = $(e).attr('data-value');

    // //     Swal.fire({
    // //         title: 'Deseja atualizar o status do usuário?',
    // //         icon: 'warning',
    // //         showCancelButton: true,
    // //         confirmButtonColor: '#3085d6',
    // //         cancelButtonColor: '#d33',
    // //         cancelButtonText: 'Cancelar',
    // //         confirmButtonText: 'Sim!'
    // //     }).then((result) => {
    // //         if (result.value) {
    // //             if(updateUserStatusFirebase(id, status)){
    // //                 Swal.fire(
    // //                 'Atualizado',
    // //                 'O status foi atalizado com sucesso!',
    // //                 'success'
    // //                 ).then((result) => {
    // //                     if(result.value){
    // //                         location.reload();
    // //                     }
    // //                 })                    
    // //             }             
    // //         }
    // //     })
    // // }

    // // //Cria o usuário
    // // function createUser(){
    // //     const user = {
    // //         cnpj: null,
    // //         currentAuthority: null,
    // //         login: null,
    // //         nome: null,
    // //         senha: null,
    // //         status : null
    // //     };

    // //     user.cnpj = $('#cnpj').val();
    // //     user.currentAuthority = $('#currentAuthority').val();
    // //     user.login = $('#login').val();
    // //     user.nome = $('#nome').val();
    // //     user.senha = $('#senha').val();
    // //     user.status = true; //por padrão vai true

    // //     if(user.cnpj != '' && user.currentAuthority != '' && user.login != '' 
    // //         && user.nome != '' && user.senha != '' && user.status != ''){
    // //         if(createUserFirebase(user)){
    // //         Swal.fire(
    // //         'Criado',
    // //         'O usuário foi criado com sucesso!',
    // //         'success'
    // //         ).then((result) => {
    // //             if(result.value){
    // //                 location.reload();
    // //             }
    // //         })         
    // //         }else{
    // //             alert('Erro ao criar o usuário, contate o administrador do sistema!');
    // //         }
    // //     }
    // //     else{
    // //         alert("Preencha todos os campos!");
    // //     }
        
    // // }


    // // //Traz os dados do usuário no modal - Utilizando PHP
    // // async function editUser(e){
    // //     var key = $(e).attr('data-user_id');
    // //     const {data} = await axios.post("{{ url('/user-update') }}", {
    // //         key
    // //     });

    // //     console.log(data[1]);
    // //     $('#keyUpdate').val(data[1]);
    // //     $('#nomeUpdate').val(data[0].nome);
    // //     $('#cnpjUpdate').val(data[0].cnpj);
    // //     $('#loginUpdate').val(data[0].login);
    // //     $('#senhaUpdate').val(data[0].senha);
    // //     $('#currentAuthorityUpdate').val(data[0].currentAuthority);
        
    // //     $('#updateModal').modal('show');
    // //     // alert(key);
    // // }


    // // //Atualiza o usuário 
    // // function updateUser(){
    // //     const user = {
    // //         cnpj: null,
    // //         currentAuthority: null,
    // //         login: null,
    // //         nome: null,
    // //         senha: null,
    // //         status : null
    // //     };

    // //     user.cnpj = $('#cnpjUpdate').val();
    // //     user.currentAuthority = $('#currentAuthorityUpdate').val();
    // //     user.login = $('#loginUpdate').val();
    // //     user.nome = $('#nomeUpdate').val();
    // //     user.senha = $('#senhaUpdate').val();
    // //     user.status = true; //por padrão vai true

    // //     var key = $('#keyUpdate').val();

    // //     console.log(user);

    // //     if(updateUserFirebase(key, user)){
    // //         Swal.fire(
    // //         'Atualizado',
    // //         'O usuário foi atualizado com sucesso!',
    // //         'success'
    // //         ).then((result) => {
    // //             if(result.value){
    // //                 $('#updateModal').modal('hide');
    // //                 location.reload();
    // //             }
    // //         })         
    // //     }else{
    // //         alert('Erro ao atualizar o usuário, contate o administrador do sistema!');
    // //     }
    // // }

        
</script>

@endsection