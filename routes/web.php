<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Rota para login
Route::get('/its', 'AdminController@home')->name('user.login');
Route::get('/', 'AdminController@home')->name('user.login');

//Confirma os dados de login
Route::post('/user-login', 'UserController@login')->name('user.check.login');

//Rota para o mapa do visitante
Route::get('/guest', 'AdminController@guest')->name('guest');


//Grupo de rotas com autenticação de login---------------------------------------------------------------
Route::group(['middleware' => 'auth'], function () {
    //Rota para a listagem de intervenções
    Route::get('/interventions', 'InterventionController@intervention')->name('intervention');
    //Rota para o mapa
    Route::get('/map', 'InterventionController@map')->name('map');
    //Rota para a listagem de usuários
    Route::get('/users', 'UserController@index')->name('user');
    //Rotas de manipulação do usuário
    Route::post('/user-register', 'UserController@register')->name('user.register');
    Route::post('/user-updateStatus', 'UserController@updateStatus')->name('user.updateStatus');
    Route::post('/user-delete', 'UserController@delete')->name('user.delete');
    Route::post('/user-update', 'UserController@update')->name('user.update');
    Route::post('/user-update-get', 'UserController@getUser')->name('user.get.update');
    Route::post('/user-logout', 'UserController@logout')->name('user.logout');

    Route::get('/user-convert', 'UserController@convertUser')->name('user.convert');
});
//----------------------------------------------------------------------------------------------------------
