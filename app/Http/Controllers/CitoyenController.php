<?php

namespace App\Http\Controllers;

use App\Citoyen;
use App\Foyer;
use App\Quartier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitoyenController extends Controller
{
    

    public function getAll()
    {
        // $citoyens = DB::table('citoyens')->select(DB::raw('CONCAT(id, "|",nom," ", prenom, " ", date_de_naissance)'))->get();
        $json = json_encode(Citoyen::select('nom', 'prenom', 'date_de_naissance')->get());
        return $json;
    }

    public function get(Request $request)
    {
        $search = $request->nom;
        if ($search == '') {
            $citoyens = Citoyen::orderby('nom','asc')->limit(5)->get();
        }else {
            $citoyens = Citoyen::orderby('nom', 'asc')->where('nom', 'like', '%'.$search.'%')->get();
        }
        
        $response = array();
        foreach ($citoyens as $citoyen) {
            $response[] = array('nom'=>$citoyen->nom, 'prenom'=>$citoyen->prenom, 'dob'=>$citoyen->date_de_naissance,'numero'=>$citoyen->foyer->numero, 'rue'=>$citoyen->foyer->rue->nom); ;
        }

        return json_encode($response);

    }
}
