<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use App\Http\Controllers\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //Traz os usuários do firebase para converter para o MySql
    // public function convertUser()
    // {
    //     DB::transaction(function () {
    //         $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')->create();
    //         $database = $factory->getDatabase();

    //         $ref = $database->getReference('users');

    //         $users = $ref->getValue();

    //         foreach ($users as $user) {
    //             $user = User::create([
    //                 'name' => $user['nome'],
    //                 'email' => $user['login'],
    //                 'password' => Hash::make($user['senha']),
    //                 'status' => $user['status'],
    //                 'cnpj' => $user['cnpj'],
    //                 'authority' => $user['currentAuthority'] == 'Admin' ? 'Administrador' : 'Usuário',
    //             ]);

    //             if (!$user) {
    //                 DB::rollback();
    //             }
    //         }

    //         DB::commit();
    //     });
    // }

    public function userUpdate(Request $request)
    {

        $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')->create();
        $database = $factory->getDatabase();

        $userKey = $request->key;
        $ref = $database->getReference('users/' . $userKey);

        $update = $ref->getValue();
        return response()->json([$update, $userKey], 200);
    }

    public function index()
    {
        $users = User::all();

        return view('register.user', compact('users'));
    }

    public function login(Request $request)
    {
        // dd($request->all());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json('Sucesso', 200);
        } else
            return response()->json('Erro ao logar', 500);
    }


    //Cadastra um Novo Usuário
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'status' => $request['status'],
            'cnpj' => $request['cnpj'],
            'authority' => $request['authority'],
        ]);

        if ($user)
            return response()->json('Usuario criado com sucesso!', 200);
        return response()->json('error', 500);
    }


    //Atualiza o Status do Usuário - Ativo ou Inativo
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);

        if ($user->status == true) {
            $user->status = false;
            $user->save();
        } else {
            $user->status = true;
            $user->save();
        }

        if ($user)
            return response()->json('Status atualizado', 200);
        return response()->json('Erro ao atualizar', 500);
    }

    //Remove o Usuário
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $delete = $user->delete();

        if ($delete)
            return response()->json('Usuario removido', 200);
        return response()->json('Erro ao remover o usuario', 500);
    }

    //Atualiza o Usuário
    public function update(Request $request)
    {
        $user = User::find($request->id);

        $update = $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'status' => $user->status,
            'cnpj' => $request['cnpj'],
            'authority' => $request['authority'],
        ]);

        if ($update)
            return response()->json('Usuario atualizado', 200);
        return response()->json('Erro ao atualizar o usuario', 500);
    }

    //Traz o usuário para ser atualizado
    public function getUser(Request $request)
    {
        $user = User::find($request->id);
        // return dd($user);

        if ($user)
            return response()->json($user, 200);
        return response()->json('Erro', 500);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $user = User::find($request->id);
        // $logout = $user->logout();
        return response()->json('Deslogado', 200);
    }
}
