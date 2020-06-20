<?php

use App\Http\Controllers\InterventionController;
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

Auth::routes();

//Rota para login
Route::get('/its', 'AdminController@home')->name('user.login');
Route::get('/', 'AdminController@home')->name('user.login');

//Confirma os dados de login
Route::post('/user-login', 'UserController@login')->name('user.check.login');

//Rota para o mapa do visitante
Route::get('/guest', 'AdminController@guest')->name('guest');

//Rota para recuperação de senha
Route::get('/password-recovery', 'UserController@recoveryPassword')->name('password.recovery');


//Faz o update no banco da nova senha
Route::post('/password-update', 'UserController@updatePassword')->name('user.password.update');

//Manipulação dos usuários
// Route::get('delete-all-users', 'UserController@deleteAllUsers');
// Route::get('/user-convert', 'UserController@convertUser')->name('user.convert');

Route::post('/send-intervention-email', 'SendEmailController@sendEmail')->name('sendEmail');



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
    Route::post('/intervention-change-streets', 'InterventionController@changeInterventionStreets')->name('change.streets');
});
//----------------------------------------------------------------------------------------------------------
