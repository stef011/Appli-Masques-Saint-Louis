<?php

namespace App\Http\Controllers;

use App\Quartier;
use App\Citoyen;
use App\Inscription;
use App\Foyer;
use App\Mail\InscriptionConfirmed;
use App\Rue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{
    public function index()
    {
        $quartiers = Quartier::all();
        return view('inscription.index', compact('quartiers'));
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
            'email'=>'email:rfc|unique:citoyens,email',
            'quartier'=>'required|integer',
            'prioritaire'=>'required|boolean',
        ]);
        $inscription = new Inscription(['numero'=>hash('crc32b',uniqid())]);

        $foyer = new Foyer(['numero'=>request('numero')]);
        $foyer->rue()->associate(Rue::find(request('rueid')));
        $foyer->quartier()->associate(request('quartier'));

        $citoyen = new Citoyen;
        $citoyen->createNotSave(request());
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
        
        return view('inscription.show', compact(['citoyen', 'membres']));
    }
    public function showGet()
    {
        $citoyen = request()->session()->get('citoyen');
        $membres = request()->session()->get('membres');

        return view('inscription.show', compact(['citoyen', 'membres']));
    }



    public function add()
    {

        if(request('prioritaire')==null){
            request()->request->add(['prioritaire'=>false]);
        }
        // dd(request('prioritaire'));
        request()->validate([
            'nom'=>'required|string',
            'prenom'=>'required|string',
            'dateNaissance'=>'required|date',
            'prioritaire'=>'required|boolean',
        ]);


        // dd(request());

        $membres = request()->session()->get('membres');
        $citoyen = request()->session()->get('citoyen');
        $membre = new Citoyen([
            'nom'=>request('nom'),
            'prenom'=>request('prenom'),
            'date_de_naissance'=>request('dateNaissance'),
            'prioritaire'=>boolval(request('prioritaire')),
        ]);

        $membres->push($membre);

        request()->session()->put([
            'membres'=>$membres,
        ]);



        return redirect(route('inscription.show'));

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

        return view('inscription.show', compact(['citoyen', 'membres']));
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

        Mail::to($chef->email)->queue(new InscriptionConfirmed($inscription));

        return view('inscription.confirmed',compact(['inscription']));
    }
}
