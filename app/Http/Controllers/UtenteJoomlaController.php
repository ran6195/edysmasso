<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class UtenteJoomlaController extends Controller
{
    public function creaUtenteJoomla(Request $request)
    {
        //return [$request->user_id, $request->site_id];

        $sito = Site::find($request->site_id);
        $user = auth()->user();

        //dd($sito);
        //$utente = User::find($request->user_id);
        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Content-type' => 'application/json',
            'Authorization' => "Bearer $sito->token"
        ])->get("https://www.$sito->domainName/api/index.php/v1/users");

        //$response = Http::withHeaders([
        //    'Accept' => '*/*' ,
        //    'Content-type' => 'application/json' ,
        //    'Authorization' => 'Bearer c2hhMjU2OjUwMzo5NGJhODU1NDUzMWFlNTQxM2NiYzg4OTYxMTQxYzA2ZjhjMWQzMzg2MWNlNWVmZjA4MWYzNWZhNjFjNmM3N2Yz'
        //])->post("https://www.$sito->domainName/api/index.php/v1/users", ['username' => $user->username_joomla,'email'=>,'name'=>'pippo','groups'=>['7']]);

        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Content-type' => 'application/json',
            'Authorization' => "Bearer $sito->token"
        ])->post("https://www.$sito->domainName/api/index.php/v1/users", [
            "block" => 0,
            "email" => "$user->email",
            "groups" => [$sito->id_gruppo_edysma],
            "id" => 0,
            "name" => "$user->email",
            "parans" => [
                "admin_language" => "",
                "admin_style" => "",
                "editor" => "",
                "helpsite" => "",
                "language" => "",
                "timezone" => ""
            ],

            "password" => "$user->password_joomla",
            "password2" => "$user->password_joomla",
            "registerDate" => "",
            "requireReset" => "0",
            "resetCount" => "0",
            "sendEmail" => "0",
            "username" => "$user->username_joomla"

        ]);


        // dd($response->status());
        return ["status" => $response->status(), "body" => $response->body()];
    }
}
