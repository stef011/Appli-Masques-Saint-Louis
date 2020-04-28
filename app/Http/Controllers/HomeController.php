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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->login) {
            case 'gestion':
                return redirect(route('gestion.index'));
                break;
            case 'admin':
                return view('admin');
            default:
                return view('distribution');
                break;
        }
    }
}
