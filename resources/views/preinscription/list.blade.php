@extends('layouts.layout')

@section('title')
Liste des préinscriptions
@endsection

@section('content')
<div class="mw-10 m-auto">
    <form action="{{ route('preinscription.search') }}" method="post" class="form-inline">
        @csrf
        <div class="form-group">
            <input type="search" name="search" id="search" placeholder="search" class="form-control col-10">
            <button type="submit" class="btn btn-primary btn-shadow">Rechercher</button>
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
        </thead>
        <tbody>
            @foreach ($citoyens as $key=>$citoyen)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{ $citoyen->nom }}</td>
                <td>{{ $citoyen->prenom }}</td>
                <td>{{ $citoyen->date_de_naissance }}</td>
                <td>{{ $citoyen->prioritaire == 1 ? 'Oui' : 'Non' }}</td>
                <td>{{ $citoyen->tel }}</td>
                <td>{{ $citoyen->inscription()->numero }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $citoyens->links() }}
</div>
@endsection
