<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class FirebaseController extends Controller
{

    // public function index(){
    //     $factory = (new Factory)->withServiceAccount(__DIR__.'/FirebaseKey.json')->create();
    //     $database = $factory->getDatabase();

    //     $ref = $database->getReference('users');

    //     $values = $ref->getValue();

    //     return dd($values);
    // }

    // public function user(){
    //     $ref = $database->getReference('users');
    //     $values = $ref->getValue();

    //     return dd($values);
    // }



}
