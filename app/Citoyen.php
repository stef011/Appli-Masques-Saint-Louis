<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citoyen extends Model
{
    public function foyer()
    {
    return $this->belongsTo(Foyer::class);
    }
    public function quartier()
    {
    return $this->hasOne(Quartier::class);
    }
}
