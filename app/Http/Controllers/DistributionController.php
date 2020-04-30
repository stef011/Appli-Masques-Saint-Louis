<?php

namespace App\Http\Controllers;

use App\Quartier;
use App\User;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quartier = Auth::user()->quartiers;
        if($quartier->count() > 1){
            return view('distribution.index', compact('quartier'));
        }
        return view('distribution.show', ['quartier'=>$quartier->first()]);
    }
    
    public function show(Quartier $quartier)
    {
        $this->authorize('update', $quartier);

        return view('distribution.show', compact('quartier'));
    }

    public function new(Quartier $quartier, Request $request)
    {
        if ($request) {
            # code...
        }
    }
}
