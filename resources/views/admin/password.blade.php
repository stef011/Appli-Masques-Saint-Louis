@extends('layouts.layout')

@section('title')
Changement de Mot de passe
@endsection

@section('content')
<div>
    <form action="{{ route('admin.password', ['user'=>$user->id]) }}" method="post" class="m-auto st-blue h4">
        <h2 class="h1 mb-5">Changement de mot de passe - {{ $user->login }}</h2>
        @csrf
        <label for="password">Nouveau mot de passe</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password') is-invalid @enderror">
        <label for="password_confirm">Confirmation</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password') is-invalid @enderror">
        <div class="mt-5 d-flex justify-content-between">
            <a href="{{ URL::previous() }}" class="btn btn-danger btn-shadow">Retour</a>
            <button type="submit" class="btn btn-success btn-shadow">Valider</button>
        </div>
    </form>
</div>
@endsection
