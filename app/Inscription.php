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
    public function citoyens()
    {
        if(null != $this->foyer){
        return $this->foyer->citoyens;
        }
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($inscription) { // before delete() method call this
            
            if ($inscription->citoyens()) {
                foreach ($inscription->citoyens() as $citoyen) {
                    $citoyen->delete();
                }
            }

        });
        static::deleted(function ($inscription)
        {
            if ($inscription->foyer) {
                $inscription->foyer->delete();
            }
        });
    }
}
