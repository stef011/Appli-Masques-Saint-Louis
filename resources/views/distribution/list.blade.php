@extends('layouts.layout')

@section('title')
Entrée du code
@endsection

@section('content')
<div class="mw-10 m-auto">
    <form action="{{ route('distribution.search', ['quartier'=>$quartier]) }}" method="post"
        class="d-flex flex-column w-100">
        @csrf
        @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
        @endif
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
            <th scope="col"><a
                    href="{{ route('distribution.list', ['sort'=>'prio','quartier'=>$quartier]) }}">Priorité</a></th>
            <th scope="col">Numéro de téléphone</th>
            <th scope="col">Numéro de demande</th>
            <th scope="col">Nombres de personnes du foyer</th>
            <th scope="col"></th>
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
                <td>{{ $citoyen->foyer->nb_masques }}</td>
                <td>
                    <a href="{{ route('distribution.showCitoyen',['inscription'=>$citoyen->inscription()->numero,'quartier'=>$quartier]) }}"
                        class="btn btn-info btn-shadow">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $citoyens->links() }}
</div>
@endsection
