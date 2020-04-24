<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rue extends Model
{
    

    public function foyers()
    {
        return $this->hasMany(Foyer::class);
    }
}
