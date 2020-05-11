<?php

namespace App\Http\Controllers;

use App\User;
use App\Quartier;
use App\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        return view('admin.index', compact('users'));
    }

    public function password(User $user)
    {
        return view('admin.password', compact('user'));
    }

    public function passwordChange(User $user)
    {
        request()->validate(['password' => 'required|string|confirmed|min:8']);
        $user->changePass(request('password'));
        return redirect()->route('admin.index')->withSuccess('Mot de passe changé');    
    }

    public function addUser()
    {
        $quartiers = Quartier::all();
        $roles = Role::all();
        $distribution = Role::where('role','distribution')->first();
        return view('admin.add', compact(['quartiers','roles', 'distribution']));
    }
    public function createUser()
    {
        request()->validate([
            'login'=>'required|unique:users,login|string',
            'password'=>'required|confirmed|string',
            'role'=>'required|int',
        ]);

        $user = new User;
        if(request('role') == Role::where('role', 'distribution')->first()->id){
            $user->createWithQuartier(request('login'),request('password'),request('role'),request('quartiers'));
        }else{
            $user->create(request('login'), request('password'),request('role'));
        }

        return redirect(route('admin.index'));
    }

    
    public function edit(User $user)
    {
        $quartiers = Quartier::all();
        $roles = Role::all();
        $distribution = Role::where('role','distribution')->first();
        return view('admin.edit', compact(['user', 'quartiers','roles', 'distribution']));
    }
    public function update(User $user)
    {
        request()->validate([
        'login'=>'required|unique:users,login,'.$user->id.'|string',
        'role'=>'required|int',
        ]);

        $user->login = request('login');
        $user->role()->associate(request('role'));
        if ($user->role->role == 'distribution') {
            $user->quartiers()->sync(request('quartiers'));
        }else{
            $user->quartiers()->sync([]);
        }
        $user->save();        

        return redirect(route('admin.index'));
    }



    public function delete(User $user)
    {
        $user->quartiers()->detach();
        $user->delete();
        return redirect(route('admin.index'));
    }
}
