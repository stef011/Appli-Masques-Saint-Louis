<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foyer extends Model
{
    public function citoyens()
    {
    return $this->hasMany(Citoyen::class);
    }
    public function rue()
    {
    return $this->belongsTo(Rue::class);
    }
}
