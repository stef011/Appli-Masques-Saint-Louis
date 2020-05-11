<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreinscriptionController extends Controller
{
    public function index()
    {
        return view('preinscription.index');
    }
}
