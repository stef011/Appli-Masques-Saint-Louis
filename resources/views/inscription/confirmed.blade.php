@extends('layouts.layout')

@section('title')
Inscription Confirmée
@endsection

@section('content')
<div class="m-auto mw-10 text-center">
    <h2 class="h1 st-blue">Félicitations, votre inscription a bien été prise en compte !</h2>
    <p class="h3 mb-3">Un mail vous a été envoyé, vous y trouverez votre numéro d'inscription comme ci-dessous.</p>
    {{-- {!! QrCode::size(250)->generate($inscription->numero) !!} --}}
    <p class="h2 st-blue">{{ $inscription->numero }}</p>
    <p class="h3">Ce dernier est à conserver, il vous permettra de récupérer votre ou vos
        masques.</p>
</div>
@endsection
