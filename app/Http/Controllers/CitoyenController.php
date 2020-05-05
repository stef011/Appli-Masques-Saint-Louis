<?php

namespace App\Http\Controllers;

use App\Citoyen;
use App\Foyer;
use App\Quartier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitoyenController extends Controller
{
    
    public function get(Request $request)
    {
        request()->validate([
            'nom'=> 'string'
        ]);

        $search = $request->nom;
        if ($search == '') {
            $citoyens = Citoyen::orderby('nom','asc')->limit(5)->get();
        }else {
            $citoyens = Citoyen::orderby('nom', 'asc')->where('nom', 'like', '%'.$search.'%')->get();
        }
        
        $response = array();
        foreach ($citoyens as $citoyen) {
            $response[$citoyen->id] = array('id'=>$citoyen->id, 'nom'=>$citoyen->nom, 'prenom'=>$citoyen->prenom, 'dob'=>$citoyen->date_de_naissance,'numero'=>$citoyen->foyer->numero, 'rue'=>$citoyen->foyer->rue->nom); ;
        }

        return json_encode($response);

    }

// Return true si le citoyen à déjà reçu son masque.
    public function check(Request $request)
    {
        $citoyen = Citoyen::find($request->id);
        if ($citoyen->date_de_demande != NULL) {
            return true;
        }else{
        return false;
        }
    }
}
