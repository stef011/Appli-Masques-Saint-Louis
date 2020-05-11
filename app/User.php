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
    public function create(String $login, String $password, Int $role)
    {
        $this->login = $login;
        $this->password = Hash::make($password);
        $this->role()->associate(Role::find($role));
        $this->save();

        return $this;
    }
    public function createWithQuartier(String $login, String $password, Int $role, $quartier)
    {
        $this->login = $login;
        $this->password = Hash::make($password);
        $this->role()->associate($role);
        $this->save();
        $this->quartiers()->attach($quartier);
        
        return $this;
    }


    public function changePass($password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }



    public function quartiers()
    {
        return $this->belongsToMany(Quartier::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
