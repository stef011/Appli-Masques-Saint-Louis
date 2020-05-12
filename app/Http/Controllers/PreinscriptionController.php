<?php

namespace App\Http\Controllers;

use App\Quartier;
use App\Citoyen;
use App\Inscription;
use App\Foyer;
use App\Rue;
use Illuminate\Http\Request;

class PreinscriptionController extends Controller
{
    public function index()
    {
        $quartiers = Quartier::all();
        return view('preinscription.index', compact('quartiers'));
    }

     public function show()
    {
        // dd(request());
        request()->validate([
            'nom'=>'required',
            'date_de_naissance'=>'required|date',
            'prenom'=>'required',
            'numero'=>'required|integer',
            'rueid'=>'required|integer',
            'tel'=>'required|numeric',
            'quartier'=>'required|integer',
            'prioritaire'=>'required|boolean',
        ]);
        $inscription = new Inscription(['numero'=>hash('crc32b',uniqid())]);

        $foyer = new Foyer(['numero'=>request('numero')]);
        $foyer->rue()->associate(Rue::find(request('rueid')));
        $foyer->quartier()->associate(request('quartier'));

        $citoyen = new Citoyen;
        $citoyen->createWithTel(request());
        // dd($citoyen);
        
        // $membres = $citoyen->foyer->citoyens;
        $membres = collect();

        $membres->prepend($citoyen);

        request()->session()->put([
            'inscription'=>$inscription,
            'citoyen'=>$citoyen,
            'membres'=>$membres,
            'foyer'=>$foyer,
        ]);
        
        return view('preinscription.show', compact(['citoyen', 'membres']));
    }
    public function showGet()
    {
        $citoyen = request()->session()->get('citoyen');
        $membres = request()->session()->get('membres');

        return view('preinscription.show', compact(['citoyen', 'membres']));
    }


    public function add()
    {

        // if(request('prioritaire')==null){
        //     request()->request->add(['prioritaire'=>false]);
        // }
        // dd(request('prioritaire'));
        request()->validate([
            'nom'=>'required|string',
            'prenom'=>'required|string',
            'dateNaissance'=>'required|date',
        ]);


        // dd(request());

        $membres = request()->session()->get('membres');
        $citoyen = request()->session()->get('citoyen');
        $membre = new Citoyen([
            'nom'=>request('nom'),
            'prenom'=>request('prenom'),
            'date_de_naissance'=>request('dateNaissance'),
            'prioritaire'=>boolval($citoyen->prioritaire),
        ]);

        $membres->push($membre);

        request()->session()->put([
            'membres'=>$membres,
        ]);



        return redirect(route('preinscription.show'));

    }

    public function remove(Int $membre)
    {
    $membres = request()->session()->get('membres');


    $membres->forget($membre);

    // dd($membres);

    request()->session()->put([
    'membres'=>$membres,
    ]);

    $citoyen = request()->session()->get('citoyen');

    return view('preinscription.show', compact(['citoyen', 'membres']));
    }

public function confirm()
    {
        $membres = request()->session()->get('membres');
        $foyer = request()->session()->get('foyer');
        $inscription = request()->session()->get('inscription');

        $inscription->save();

        $foyer->inscription()->associate($inscription);
        $foyer->save();

        foreach($membres as $citoyen){
            $citoyen->foyer()->associate($foyer);
            $citoyen->save();
        }
        $chef = request()->session()->get('citoyen');


        request()->session()->forget(['inscription','citoyens','membres','foyer']);
        return redirect(route('preinscription.index'))->withSuccess('Inscription validée');

    }


    // public function search()
    // {
    //     request()->validate([
    //         'search'->'required',
    //     ]);
    //     $results = Citoyens::cont
    // }
}
