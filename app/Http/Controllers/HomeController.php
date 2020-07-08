<?php

namespace App\Http\Controllers;

use App\Quartier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
                switch (Auth::user()->role->role) {
                case 'gestion':
                    return redirect(route('gestion.index'));
                    break;
                case 'admin':
                    return redirect(route('admin.index'));
                break;
                case 'preinscription':
                    return redirect(route('preinscription.index'));
                break;
                case 'distribution':
                    return redirect(route('distribution.index'));
                break;
                default:
                    return view('accueil');
            }
        }
        return view('accueil');
    }

    public function rgpd()
    {
        return view('rgpd');
    }

}
