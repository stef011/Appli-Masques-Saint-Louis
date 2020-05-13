<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citoyen extends Model
{
    protected $fillable=[
        'nom',
        'prenom',
        'date_de_naissance',
        'prioritaire',
    ];

    public function distribue(Quartier $quartier)
    {
        if($this->date_de_demande == null){
            $this->date_de_demande = NOW();
            $this->quartier()->associate($quartier);
        }else{
            $this->date_de_demande = NOW();
        }
        $this->quartier->distribue();
        $this->save();
        return $this;
    }

    public function createNotSave($request)
    {
        // dd(request());
        
        // $foyer = Foyer::where('numero', $request->numero)->where('rue_id', Rue::where('nom', $request->rue)->first()->id)->first();
        // if($foyer === null)
        // {
        //     $foyer = new Foyer;
        //     $foyer->numero = $request->numero;
        //     $foyer->rue()->associate(Rue::find($request->rueid));
        //     // $foyer->inscription()->associate($request->inscription->id);
        // }

        $this->nom = $request->nom;
        $this->prenom = $request->prenom;
        $this->email = $request->email;
        $this->date_de_naissance = $request->date_de_naissance;
        $this->prioritaire = $request->prioritaire;
        // $this->foyer()->associate($foyer);
        // $this->foyer->quartier()->associate($request->quartier);
        return $this;
    }

    public function createWithTel($request)
    {
    // dd(request());

    // $foyer = Foyer::where('numero', $request->numero)->where('rue_id', Rue::where('nom',$request->rue)->first()->id)->first();
    // if($foyer === null)
    // {
    // $foyer = new Foyer;
    // $foyer->numero = $request->numero;
    // $foyer->rue()->associate(Rue::find($request->rueid));
    // // $foyer->inscription()->associate($request->inscription->id);
    // }

    $this->nom = $request->nom;
    $this->prenom = $request->prenom;
    $this->tel = $request->tel;
    $this->date_de_naissance = $request->date_de_naissance;
    $this->prioritaire = $request->prioritaire;
    // $this->foyer()->associate($foyer);
    // $this->foyer->quartier()->associate($request->quartier);
    return $this;
    }



    public function foyer()
    {
    return $this->belongsTo(Foyer::class);
    }
    public function quartier()
    {
        return $this->foyer->quartier;
    }
    public function inscription(){
        return $this->foyer->inscription;
    }

}
