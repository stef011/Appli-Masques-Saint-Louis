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

    <label for="login">Identifiant</label>
    <input type="text" name="login" id="login" class="form-control form-control-lg">

    <label for="password" class="text-nowrap">Mot de Passe</label>
    <input type="password" name="password" id="password" class="form-control form-control-lg">

    <button type="submit" class="btn btn-lg btn-primary btn-lg float-right mt-5 btn-shadow">Se connecter</button>

</form>
@endsection
