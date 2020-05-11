<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foyer extends Model
{

    protected $fillable = [
        'numero'
    ];
    public $timestamps = false;

    public function citoyens()
    {
    return $this->hasMany(Citoyen::class);
    }
    public function rue()
    {
    return $this->belongsTo(Rue::class);
    }
    public function inscription()
    {
        return $this->BelongsTo(Inscription::class);
    }
    public function quartier()
    {
    return $this->belongsTo(Quartier::class);
    }
    
}
