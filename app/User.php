<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Fonction pour créer un nouvel utilisateur
    public function create(String $login, String $password)
    {
        $this->login = $login;
        $this->password = Hash::make($password);
        $this->save();
        if(Quartier::where('nom', $login)->get()->count() >0){
            $this->quartiers()->attach(Quartier::where('nom',$login)->get());
        }
        return $this;
    }



    public function quartiers()
    {
        return $this->belongsToMany(Quartier::class);
    }
}
