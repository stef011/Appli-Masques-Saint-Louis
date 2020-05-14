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
        <p class="h3 float-right mt-1">Nombre de masques à distribuer : {{ $membres->count() }}</p>
    </div>
    <div class="d-flex justify-content-between mt-5">
        <a href="{{ URL::previous() }}" class="btn btn-danger btn-sha">Annuler</a>
        @if ($citoyen->tel == '')
        <a href="{{ route('inscription.edit', ['inscription'=>$inscription->numero]) }}"
            class="btn btn-warning btn-shadow">Modifier la Demande</a>
        @endif
        <a href="{{ route('distribution.validate', ['quartier'=>$quartier->id, 'inscription' => $inscription->numero]) }}"
            class="btn btn-success btn-shadow">Valider
            la distribution</a>
    </div>
</div>

@endsection
