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

        //dd($sito);
        $utente = User::find($request->user_id);
        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Content-type' => 'application/json',
            'Authorization' => "Bearer $sito->token"
        ])->get("https://www.$sito->domainName/api/index.php/v1/users");

        return $response->body();
    }
}
