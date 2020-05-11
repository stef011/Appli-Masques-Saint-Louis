<?php

namespace App\Http\Controllers;

use App\Rue;
use Illuminate\Http\Request;

class RueController extends Controller
{
    public function get(Request $request)
    {
        request()->validate([
        'rue'=> 'string'
        ]);

        $search = $request->rue;
        if ($search == '') {
        $rues = Rue::orderby('nom','asc')->limit(5)->get();
        }else {
        $rues = Rue::orderby('nom', 'asc')->where('nom', 'like', '%'.$search.'%')->limit(7)->get();
        }

        $response = array();
        foreach ($rues as $rue) {
        $response[] = array('id'=>$rue->id, 'nom'=>$rue->nom);
        }

        return json_encode($response);
    }
}
