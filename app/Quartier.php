<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    
    public $timestamps = false;


    public function getRouteKeyName()
    {
        return 'nom';
    }

    
    
    public function add(Int $number)
    {
        $this->stock += $number;
        $this->save();
        return true;
    }
    
    public function distribue()
    {
        $this->stock--;
        $this->distribue++;
        $this->save();
    }

    // Relations

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function foyer()
    {
        return $this->hasMany(Foyer::class);
    }
    public function rues()
    {
        return $this->hasMany(Rue::class);
    }
    public function citoyens()
    {
        return $this->foyer->citoyens;
    }
}
