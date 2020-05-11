<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = ['numero'];

    public function foyer()
    {
        return $this->hasOne(Foyer::class);
    }
}
