<?php

namespace App\Http\Controllers;


use App\Models\Site;
use App\Models\SiteUser;
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

        //$response = Http::withHeaders([
        //    'Accept' => '*/*',
        //    'Content-type' => 'application/json',
        //    'Authorization' => "Bearer $sito->token"
        //])->get("https://www.$sito->domainName/api/index.php/v1/users");


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

        $status = $response->status();
        $body = $response->body();


        // dd($response->status());
        return ["status" => $status, "body" => $body];
    }

    public function authUser(Request $request)
    {

        if (SiteUser::where([['site_id', $request->site_id], ['user_id', $request->user_id]])->count() == 0) {

            $us = new SiteUser();
            $us->site_id = $request->site_id;
            $us->user_id = $request->user_id;

            $us->save();

            return ['messaggio' => 'Associazione creata'];
        }

        return ['messaggio' => 'Associazione già esistente'];
    }
}
