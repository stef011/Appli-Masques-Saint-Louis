@extends('layouts.layout')

@section('title')
Inscription Confirmée
@endsection

@section('content')
<div class="m-auto mw-10 text-center">
    <h2 class="h1 st-blue">Félicitations, votre inscription a bien été modifiée !</h2>
    <p class="h3 mb-3">Pour rappel, voici votre numéro d'inscription.</p>
    {{-- {!! QrCode::size(250)->generate($inscription->numero) !!} --}}
    <p class="h2 st-blue">{{ $inscription->numero }}</p>
    <p class="h3">Ce dernier est à conserver, il vous permettra de récupérer votre ou vos
        masques.</p>
</div>
@endsection
