@extends('layouts.layout')

@section('title')
Connexion
@endsection


@section('content')

@if (session('success'))
<p class="alert alert-danger w-50 m-auto"> {{ session('success') }} </p>
@endif

<form action="login" method="POST" class="mx-auto st-blue">
    @csrf

    <div class="form-row">
        <div class="col">
            <label for="login">Identifiant</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="login" id="login" class="form-control form-control-lg">
        </div>
    </div>

    <div class="form-row mt-3">
        <div class="col">
            <label for="password">Mot de Passe</label>
        </div>
        <div class="col-md-8">
            <input type="password" name="password" id="password" class="form-control form-control-lg">
        </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary btn-lg float-right mt-5 btn-shadow">Se connecter</button>

</form>
@endsection
