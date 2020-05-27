@extends('layouts.layout')

@section('title')
Liste des préinscriptions
@endsection

@section('content')
<div class="mw-10 m-auto">
    <form action="{{ route('preinscription.search') }}" method="post" class="d-flex flex-column w-100">
        @csrf
        <div class="form-row form-group col-10">
            <div class="form-group">
                <input type="search" name="search" id="search" placeholder="Rechercher" class="form-control">
            </div>
            <div class="form-group col-2">
                <button type="submit" class="btn btn-primary btn-shadow">Rechercher</button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Date de Naissance</th>
            <th scope="col"><a href="{{ route('preinscription.list', ['sort'=>'prio']) }}">Priorité</a></th>
            <th scope="col">Numéro de téléphone</th>
            <th scope="col">Numéro de demande</th>
            <th scope="col">Nombres de personnes du foyer</th>
            <th scope="col">Adresse</th>
            <th scope="col"></th>
        </thead>
        <tbody>
            @foreach ($citoyens as $key=>$citoyen)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{ $citoyen->nom }}</td>
                <td>{{ $citoyen->prenom }}</td>
                <td>{{ date('d-m-Y', strtotime($citoyen->date_de_naissance)) }}</td>
                <td>{{ $citoyen->prioritaire == 1 ? 'Oui' : 'Non' }}</td>
                <td>{{ $citoyen->tel }}</td>
                <td>{{ $citoyen->inscription()->numero }}</td>
                <td>{{ $citoyen->foyer->nb_masques }}</td>
                <td>{{ $citoyen->foyer->numero }} {{ $citoyen->foyer->rue->nom }}</td>
                <td>
                    @if($citoyen->tel != '')
                    <a href="{{ route('preinscription.edit',['inscription'=>$citoyen->inscription()->numero]) }}"
                        class="btn btn-warning btn-shadow">Modifier</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $citoyens->links() }}
</div>
@endsection
