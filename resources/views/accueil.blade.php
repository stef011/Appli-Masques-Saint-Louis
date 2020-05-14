@extends('layouts.layout')

@section('title')
Accueil
@endsection

@section('content')
<div class="mw-10 m-auto">
    <h2 class="h1">Distribution gratuite de masques homologués à la population.</h2>
    <a href="{{ route('inscription.index') }}" class="btn btn-primary btn-shadow mt-5 btn-lg ">Se pré-inscrire à la
        Distribution</a>
    <a href="{{ route('inscription.get') }}" class="btn btn-primary btn-shadow mt-5 btn-lg">Modifier mon inscription</a>

</div>
@endsection
