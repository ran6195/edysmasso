<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class HtmlController extends Controller
{
    public function tabella_autorizzazioni(Request $request)
    {

        if ($request->righe == '') {
            $righe = Site::all()->filter(function ($i) {
                return $i->utenti->count() > 0;
            });

            return view('partials.tabella_autorizzazioni', ['righe' => $righe]);
        }
        return view('partials.tabella_autorizzazioni', ['righe' => $request->righe]);
    }
}
