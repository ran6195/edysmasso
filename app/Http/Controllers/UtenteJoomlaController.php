<?php

namespace App\Http\Controllers;


use App\Models\Site;
use App\Models\User;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Actions\ReturnTitle;

class UtenteJoomlaController extends Controller
{
    public function createUtenteJoomla(Request $request)
    {

        //dd($request->user_id);

        $sito = Site::find($request->site_id);

        if (isset($request->user_id)) {
            $user = User::find($request->user_id);
        } else {
            $user = auth()->user();
        }



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
            //"groups" => [$sito->id_gruppo_edysma],
            "groups" => ["7"],

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

    public function deleteUtenteJoomla(Request $request)
    {
        $s = Site::find($request->site_id);


        //recupero gli uetnti del sito
        $id = $this->getJoomlaUserId($request);



        if ($id) {
            $response = Http::withHeaders([
                'Accept' => '*/*',
                'Content-type' => 'application/json',
                "Authorization" => "Bearer $s->token"
            ])->delete("https://www.$s->domainName/api/index.php/v1/users/$id");


            return $response->body();
        }

        return;
    }


    public function getJoomlaUserId(Request $request)
    {
        $u = User::find($request->user_id);
        $s = Site::find($request->site_id);

        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Content-type' => 'application/json',
            "Authorization" => "Bearer $s->token"
        ])->get("https://www.$s->domainName/api/index.php/v1/users");



        $result = collect($response->json('data'))->filter(function ($i) use ($u) {
            return $i['attributes']['username'] == $u->username_joomla;
        });

        if ($result->count()) {
            return $result->first()['id'];
        }

        return -1;
    }

    public function getJoomlaUserList(Request $request)
    {
        $s = Site::find($request->site_id);


        if ($s->token) {
            $response = Http::withHeaders([
                'Accept' => '*/*',
                'Content-type' => 'application/json',
                "Authorization" => "Bearer $s->token"
            ])->get("https://www.$s->domainName/api/index.php/v1/users");

            return $response->json('data');
        }

        return [];
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

    public function toggleAuthUser(Request $request)
    {
        $au = SiteUser::where([['site_id', $request->site_id], ['user_id', $request->user_id]]);

        if ($au->count()) {
            $this->deleteUtenteJoomla($request);
            $au->delete();
            return 0;
        } else {
            $au = SiteUser::where([['site_id', $request->site_id], ['user_id', $request->user_id]])->withTrashed();
            if ($au->count()) {
                $au->restore();
            } else {
                $us = new SiteUser();
                $us->site_id = $request->site_id;
                $us->user_id = $request->user_id;

                $us->save();
            }

            return $this->createUtenteJoomla($request)['status'];
        }
    }
}
