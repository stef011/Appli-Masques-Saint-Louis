<?php

namespace App\Http\Controllers;

use App\Quartier;
use App\Citoyen;
use App\Inscription;
use App\Foyer;
use App\Rue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PreinscriptionController extends Controller
{
    public function index()
    {
        $quartiers = Quartier::all();
        if (Auth::user()->role->role == 'distribution') {
            $quartier = request()->session()->get('quartierDistribution');
            return view('preinscription.index', compact(['quartiers', 'quartier']));
        }
        return view('preinscription.index', compact(['quartiers']));
    }

     public function show()
    {
        // dd(request());
        request()->validate([
            'nom'=>'required',
            'date_de_naissance'=>'required|date',
            'prenom'=>'required',
            'numero'=>'required',
            'rueid'=>'required|integer',
            'tel'=>'numeric',
            'quartier'=>'required|integer',
            'prioritaire'=>'required|boolean',
            'nb_masques'=>'nullable|integer',
        ]);
        $inscription = new Inscription(['numero'=>hash('crc32b',uniqid())]);

        $foyer = new Foyer(['numero'=>request('numero'), 'nb_masques'=>request('nb_masques')]);
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

       if (Auth::user()->role->role == 'distribution') {
          $quartier = request()->session()->get('quartierDistribution');
          return view('preinscription.show', compact(['citoyen', 'membres', 'quartier']));
       }
        return view('preinscription.show', compact(['citoyen', 'membres']));
    }
    public function showGet()
    {
        $citoyen = request()->session()->get('citoyen');
        $membres = request()->session()->get('membres');
        if (Auth::user()->role->role == 'distribution') {
        $quartier = request()->session()->get('quartierDistribution');
        return view('preinscription.show', compact(['citoyen', 'membres', 'quartier']));
        }

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

        $oldMembres = $membres;

        $membres = $membres->unique(function ($item)
        {
            return $item->nom.$item->prenom.$item->date_de_naissance;
        });

        if ($oldMembres !== $membres) {
            $error = 'Ce membre existe déjà !';
        }

        request()->session()->put([
            'membres'=>$membres,
        ]);


        return redirect(Auth::user()->role->role == 'preinscription' ? route('preinscription.show') : route('distribution.showInscription'))->withSuccess($error);

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
    
    if (Auth::user()->role->role == 'distribution') {
        $quartier = request()->session()->get('quartierDistribution');
        return view('preinscription.show', compact(['citoyen', 'membres', 'quartier']));
    }

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


        request()->session()->forget(['inscription','citoyens','membres','foyer']);
        return redirect(route('preinscription.index'))->withSuccess('Inscription validée');

    }


    public function list()
    {
        if(request('prio')=='prio'){
            $citoyens = Citoyen::orderBy('prioritaire', 'desc')->simplePaginate('25');
        }else{
            $citoyens = Citoyen::simplePaginate('25');
        }
        


        return view('preinscription.list', compact('citoyens'));
        
    }


    public function search()
    {
        request()->validate([
            'search'=>'required',
        ]);
        $citoyens = Citoyen::whereHas('foyer.inscription',function($querry)
        {
            $querry->where('numero', 'like', '%'.request('search').'%');
        })
        ->orwhere('nom', 'like', '%'.request('search').'%')
        ->orWhere('prenom', 'like','%'.request('search').'%')
        ->paginate('25');
        return view('preinscription.list', compact('citoyens'));
    }




    public function edit(Inscription $inscription)
    {
        $quartiers = Quartier::all();
        return view('preinscription.edit', compact('inscription', 'quartiers'));
    }

    public function editPut(Inscription $inscription)
    {
        request()->validate([
            'nom'=>'required',
            'date_de_naissance'=>'required|date',
            'prenom'=>'required',
            'numero'=>'required',
            'rueid'=>'required|integer',
            'tel'=>'required|numeric',
            'quartier'=>'required|integer',
            'prioritaire'=>'required|boolean',
            'nb_masques'=>'nullable|integer',
        ]);

        $citoyen = $inscription->citoyens()->first();


        $citoyen->nom = request('nom');
        $citoyen->date_de_naissance = request('date_de_naissance');
        $citoyen->prenom = request('prenom');
        $citoyen->email = request('email');
        $citoyen->tel = request('tel');
        $citoyen->prioritaire = boolval(request('prioritaire'));
        // dd([request('prioritaire'), $citoyen->prioritaire]);

        $citoyen->foyer->numero = request('numero');
        $citoyen->foyer->rue_id = request('rueid');
        $citoyen->foyer->quartier_id = request('quartier');
        $citoyen->foyer->nb_masques = request('nb_masques');
        
        $membres = $inscription->citoyens();

        request()->session()->put([
            'citoyen'=>$citoyen,
            'membres'=>$membres,
            'foyer' => $citoyen->foyer,
        ]);
        request()->session()->put([]);
        
        if (Auth::user()->role->role == 'distribution') {
          $quartier = request()->session()->get('quartierDistribution');
          return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen', 'quartier']));
        }
        
        return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen']));
        
    }

    public function editMembre(Inscription $inscription)
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

        $oldMembres = $membres;

        $membres = $membres->unique(function ($item)
        {
            return $item->nom.$item->prenom.$item->date_de_naissance;
        });

        if ($oldMembres !== $membres) {
            $error = 'Ce membre existe déjà !';
        }

        request()->session()->put([
            'membres'=>$membres,
        ]);


        if (Auth::user()->role->role == 'distribution') {
          $quartier = request()->session()->get('quartierDistribution');
          return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen', 'quartier']));
        }


        return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen']));

    }

    public function editMembreRemove(Inscription $inscription, Int $membre)
    {
        $membres = request()->session()->get('membres');

        $membres->get($membre)->delete();
        $membres->forget($membre);

        // dd($membres);

        request()->session()->put([
        'membres'=>$membres,
        ]);

        $citoyen = request()->session()->get('citoyen');

        if (Auth::user()->role->role == 'distribution') {
          $quartier = request()->session()->get('quartierDistribution');
          return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen', 'quartier']));
        }

        return view('preinscription.editMembres', compact(['inscription', 'membres', 'citoyen']));
    }

    public function confirmEdit(Inscription $inscription)
    {
        // if(null !== request()->session()->get('citoyen')){
        //     $membres = request()->session()->get('membres');
        //     $foyer = request()->session()->get('foyer');

        //     $foyer->save();

        //     foreach($membres as $citoyen){
        //         $citoyen->foyer()->associate($foyer);
        //         $citoyen->prioritaire = request()->session()->get('citoyen')->prioritaire;
        //         $citoyen->save();
        //     }
        // }
        // if(request()->session()->get('changed') == true){
        //     $chef = request()->session()->get('citoyen');

        //     Mail::to($chef->email)->queue(new InscriptionConfirmed($inscription));
        // }

        // request()->session()->forget(['citoyen','membres','foyer']);

        // return view('preinscription.editConfirmed',compact(['inscription']));

        $membres = request()->session()->get('membres');
        $foyer = request()->session()->get('foyer');

        $inscription->save();

        $foyer->inscription()->associate($inscription);
        $foyer->save();

        foreach($membres as $citoyen){
        $citoyen->foyer()->associate($foyer);
        $citoyen->save();
        }
        $chef = request()->session()->get('citoyen');


        request()->session()->forget(['inscription','citoyens','membres','foyer']);
        return redirect(route('preinscription.index'))->withSuccess('Modification(s) validée(s)');

    }

    public function delete(Foyer $foyer)
    {
        $foyer->inscription->delete();
        return redirect(route('preinscription.index'))->withSuccess('Foyer et Inscription supprimé !');
    }
}
