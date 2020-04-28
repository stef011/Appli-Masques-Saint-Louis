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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function add(Int $number)
    {
        $this->stock += $number;
        $this->save();
        return true;
    }
}
