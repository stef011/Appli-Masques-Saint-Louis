@extends('layouts.layout')

@section('title')
{{ $citoyen->nom . ' ' . $citoyen->prenom }} Distribution
@endsection

@section('content')
<div class="m-auto mw-10">
    <table class="table table-striped table-bordered m-auto h5 text-center mw-10">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de Naissance</th>
            </tr>
        </thead>
        <tbody id="lignes">
            @foreach ($membres as $key=>$membre)
            <tr>
                <th>{{ $key + 1 }}</th>
                <td>{{ $membre->nom }}</td>
                <td>{{ $membre->prenom }}</td>
                <td>{{ date('d-m-Y', strtotime($membre->date_de_naissance)) }}</td>

            </tr>

            @endforeach
        </tbody>
    </table>
    <div>
        <p class="h3 float-right mt-1">Nombre de masques à distribuer :
            {{ $citoyen->foyer->nb_masques != '' ? $citoyen->foyer->nb_masques : $membres->count() }}</p>
    </div>
    <div class="d-flex justify-content-between mt-5">
        <a href="{{ route('distribution.list', ['quartier'=>$quartier]) }}" class="btn btn-danger btn-sha">Annuler</a>
        @if ($citoyen->tel == '')
        <form action="{{ route('inscription.edit', ['inscription'=>$citoyen->inscription()->numero]) }}" method="post"
            class="mt-0">
            @csrf
            @method('PUT')

            <input type="hidden" value="{{ $citoyen->nom }}" name="nom">
            <input type="hidden" value="{{ $citoyen->date_de_naissance }}" name="date_de_naissance">
            <input type="hidden" value="{{ $citoyen->prenom }}" name="prenom">
            <input type="hidden" value="{{ $citoyen->foyer->numero }}" name="numero">
            <input type="hidden" value="{{ $citoyen->foyer->rue->id }}" name="rueid">
            <input type="hidden" value="{{ $citoyen->email }}" name="email">
            <input type="hidden" value="{{ $citoyen->foyer->quartier_id }}" name="quartier">
            <input type="hidden" value="{{ $citoyen->prioritaire }}" name="prioritaire">

            <button type="submit" class="btn btn-warning btn-shadow">Modifier</button>

        </form>
        {{-- <a href="{{ route('inscription.edit', ['inscription'=>$inscription->numero]) }}"
        class="btn btn-warning btn-shadow">Modifier la Demande</a> --}}
        @endif
        <a href="{{ route('distribution.validate', ['quartier'=>$quartier->id, 'inscription' => $inscription->numero]) }}"
            class="btn btn-success btn-shadow">Valider
            la distribution</a>
    </div>
</div>

@endsection
