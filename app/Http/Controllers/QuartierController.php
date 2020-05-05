<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quartier;

class QuartierController extends Controller
{
    

    public function stock(Quartier $quartier)
    {
        request()->validate([
        'stockAdd'=> 'required|integer|gt:0'
        ]);

        $quartier->add(request('stockAdd'));

        return redirect(route('gestion.index'));
        
    }
}
