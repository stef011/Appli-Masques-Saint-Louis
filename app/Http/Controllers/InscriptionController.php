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
use Illuminate\Validation\Rule;

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
        if(null !== request()->session()->get('citoyen')){
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
        }

        $inscription = request()->session()->get('inscription');

        request()->session()->forget(['citoyen','membres','foyer']);

        return view('inscription.confirmed',compact(['inscription']));

    }


    public function get()
    {
        if (request()->method() == 'POST') {
            request()->validate(['code'=>'required']);
            if (Inscription::where('numero', request('code'))->first() != null) {
                return redirect(route('inscription.edit', ['inscription'=>request('code')]));
            }
            return redirect(route('inscription.get'))->withSuccess('Vous n\'êtes pas inscrit ou votre code a mal été entré');
        }
        return view('inscription.get');
    }


    public function edit(Inscription $inscription)
    {
        $quartiers = Quartier::all();
        return view('inscription.edit', compact('inscription', 'quartiers'));
    }

    public function editPut($inscription)
    {
        
                $inscriptions = Inscription::where('numero', $inscription)->get();
        
                foreach ($inscriptions as $insc ) {
                    if ($insc->citoyens() && $insc->citoyens()->count() > 0) {
                        // dd($insc);
                        $inscription = $insc;
                    }
                }
        request()->validate([
            'nom'=>'required',
            'date_de_naissance'=>'required|date',
            'prenom'=>'required',
            'numero'=>'required|integer',
            'rueid'=>'required|integer',
            'email'=>['email:rfc',Rule::unique('citoyens')->ignore($inscription->citoyens()->first())],
            'quartier'=>'required|integer',
            'prioritaire'=>'required|boolean',
        ]);

        $citoyen = $inscription->citoyens()->where('email','!=','')->first();

        if(request('email') != $citoyen->email){
            $changed = true;
        }else{
            $changed = false;
        }
        $citoyen->nom = request('nom');
        $citoyen->date_de_naissance = request('date_de_naissance');
        $citoyen->prenom = request('prenom');
        $citoyen->email = request('email');
        $citoyen->prioritaire = boolval(request('prioritaire'));
        // dd([request('prioritaire'), $citoyen->prioritaire]);

        $citoyen->foyer->numero = request('numero');
        $citoyen->foyer->rue_id = request('rueid');
        $citoyen->foyer->quartier_id = request('quartier');
        
        $membres = $inscription->citoyens();

        request()->session()->put([
            'citoyen'=>$citoyen,
            'membres'=>$membres,
            'foyer' => $citoyen->foyer,
            'changed' =>$changed,
        ]);
        request()->session()->put([]);
        
        return view('inscription.editMembres', compact(['inscription', 'membres', 'citoyen']));
        
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

        request()->session()->put([
            'membres'=>$membres,
        ]);



        return view('inscription.editMembres', compact(['inscription', 'membres', 'citoyen']));

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

        return view('inscription.editMembres', compact(['inscription', 'membres', 'citoyen']));
    }

    public function confirmEdit(Inscription $inscription)
    {
        if(null !== request()->session()->get('citoyen')){
            $membres = request()->session()->get('membres');
            $foyer = request()->session()->get('foyer');

            $foyer->save();

            foreach($membres as $citoyen){
                $citoyen->foyer()->associate($foyer);
                $citoyen->prioritaire = request()->session()->get('citoyen')->prioritaire;
                $citoyen->save();
            }
        }
        if(request()->session()->get('changed') == true){
            $chef = request()->session()->get('citoyen');

            Mail::to($chef->email)->queue(new InscriptionConfirmed($inscription));
        }

        request()->session()->forget(['citoyen','membres','foyer']);

        return view('inscription.editConfirmed',compact(['inscription']));

    }




}
