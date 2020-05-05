<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citoyen extends Model
{

    public function distribue(Quartier $quartier)
    {
        if($this->date_de_demande == null){
            $this->date_de_demande = NOW();
            $this->created_at = NOW();
            $this->quartier()->associate($quartier);
        }else{
            $this->date_de_demande = NOW();
        }
        $this->quartier->distribue();
        $this->save();
        return $this;
    }



    public function foyer()
    {
    return $this->belongsTo(Foyer::class);
    }
    public function quartier()
    {
    return $this->belongsTo(Quartier::class);
    }
}
