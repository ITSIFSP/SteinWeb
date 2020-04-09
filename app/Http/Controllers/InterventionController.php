<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class InterventionController extends Controller
{

    //Traz as intervenções para listagem e manipulação
    public function intervention()
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')->create();
        $database = $factory->getDatabase();

        $ref = $database->getReference('interdictions');

        $interventions = $ref->getValue();

        return view('intervention.intervention', compact('interventions'));
    }

    public function map()
    {
        return view('map.map');
    }
}
