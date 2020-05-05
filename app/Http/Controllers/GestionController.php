<?php

namespace App\Http\Controllers;

use App\Quartier;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('gestion');
    }

    public function index()
    {
        $quartiers = Quartier::all();
        return view('gestion.index', compact('quartiers'));
    }

    public function show(Quartier $quartier)
    {
        return view('gestion.show',
        [
            'quartier' => $quartier
        ]);
    }
}
