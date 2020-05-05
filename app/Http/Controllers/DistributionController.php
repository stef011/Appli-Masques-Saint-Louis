<?php

namespace App\Http\Controllers;

use App\Citoyen;
use App\Quartier;
use App\User;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quartier = Auth::user()->quartiers;
        if($quartier->count() > 1){
            return view('distribution.index', compact('quartier'));
        }
        return view('distribution.show', ['quartier'=>$quartier->first()]);
    }
    
    public function show(Quartier $quartier)
    {
        $this->authorize('update', $quartier);

        return view('distribution.show', compact('quartier'));
    }

    public function new(Quartier $quartier)
    {
        if (request('id')) {
            request()->validate([
                'id'=>'integer|required|gt:0'
            ]);
            $citoyen = Citoyen::find(request('id'));
            $membres = $citoyen->foyer->citoyens;
        }else{
            request()->validate([
                'nom'=>'required|string',
                'prenom'=>'required|string',
                'dateNaissance' => 'required|string',
            ]);
            $citoyen = Citoyen::where('nom',request('nom'))
                    ->where('prenom', request('prenom'))
                    ->where('date_de_naissance', request('dateNaissance'))
                    ->first();
            if ($citoyen){
                $membres = $citoyen->foyer->citoyens;
            }else{
                return view('distribution.demande');
            }
        }
        return view('distribution.demande', compact('citoyen', 'membres', 'quartier'));
        
    }

    public function create(Quartier $quartier)
    {
        $validator = Validator::make(request()->all(), [
        'citoyens' => 'required'
        ]);

        if ($validator->fails()) {
        return redirect(route('distribution.show', ['quartier' => $quartier->id]));
        }
        request()->validate([
            'citoyens' => 'required'
        ]);
        $citoyens = Citoyen::find(request('citoyens'));
        foreach ($citoyens as $citoyen) {
            $citoyen->distribue($quartier);
        }
        return redirect()->route('distribution.show', ['quartier' => $quartier->id])->withSuccess('Succès !');
    }
}
