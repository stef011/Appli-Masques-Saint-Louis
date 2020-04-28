<?php

namespace App\Http\Controllers;

use App\Quartier;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        return view('gestion.index',
        [
        'centre' => Quartier::where('nom', 'centre')->first(),
        'neuweg' => Quartier::where('nom', 'neuweg')->first(),
        'bourgfelden' => Quartier::where('nom', 'bourgfelden')->first(),
        ]);
    }

    public function show(Quartier $quartier)
    {
        return view('gestion.show',
        [
            'quartier' => $quartier
        ]);
    }
}
