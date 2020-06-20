<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

        $users = User::all();

        return view('intervention.intervention', compact('interventions', 'users'));
    }

    public function map()
    {
        return view('map.map');
    }

    public function changeInterventionStreets(Request $request)
    {
        $id = $request->id;

        $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')->create();
        $database = $factory->getDatabase();

        $ref = $database->getReference('interdictions/' . $id);

        $intervention = $ref->getValue();


        //Inverte as posições dos nodes de destination para origin
        $originStreet = $intervention['origin']['street'];
        $destinationStreet = $intervention['destination']['street'];

        $aux = $originStreet;
        $originStreet = $destinationStreet;
        $destinationStreet = $aux;

        $auxOriginLat = $intervention['origin']['lat'];
        $auxOriginLng = $intervention['origin']['lng'];

        $intervention['origin']['lat'] = $intervention['destination']['lat'];
        $intervention['origin']['lng'] = $intervention['destination']['lng'];

        $intervention['destination']['lat'] = $auxOriginLat;
        $intervention['destination']['lng'] = $auxOriginLng;


        $intervention['origin']['street'] = $originStreet;
        $intervention['destination']['street'] = $destinationStreet;

        $ref->update($intervention);

        return response()->json('intervention updated', 200);
    }
}
