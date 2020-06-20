<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptanceEmail;
use App\User;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class SendEmailController extends Controller
{
    public function getIntervention($key)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')->create();
        $database = $factory->getDatabase();

        $ref = $database->getReference('interdictions/' . $key);

        $interventions = $ref->getValue();

        return $interventions;
    }

    public function sendEmail(Request $request)
    {

        $interventionKey = $request[1];
        $userIds = $request[0];
        $users = array();

        $organization = $request[2];

        foreach ($userIds as $user) {
            array_push($users, User::find($user['id']));
        }
        $emails = array();
        // dd($users['email']);

        foreach ($users as $user) {
            array_push($emails, $user['email']);
        }

        $data = null;
        $data = $this->getIntervention($interventionKey);

        // for ($i = 0; $i < count($emails); $i++) {
        //     Mail::to($emails[$i])->send(new AcceptanceEmail($data, $organization));
        // }

        Mail::to($emails)->send(new AcceptanceEmail($data, $organization));


        return back()->with('success', 200);
    }
}
