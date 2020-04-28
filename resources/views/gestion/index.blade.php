@extends('layouts.layout')

@section('title')
Gestion des Stocks
@endsection


@section('content')
<div class="m-5 w-75 m-auto">
    <table class="table m-auto h4 text-center">
        <thead>
            <th scope="col">Quartier</th>
            <th scope="col">Centre</th>
            <th scope="col">Neuweg</th>
            <th scope="col">Bourgfelden</th>
        </thead>
        <tbody>
            <tr>
                <th>Distribués</th>
                <td>{{ $centre->distribue }}</td>
                <td>{{ $neuweg->distribue }}</td>
                <td>{{ $bourgfelden->distribue }}</td>
            </tr>
            <tr>
                <th class="pb-5">Restants</th>
                <td class="pb-5">{{ $centre->stock }}</td>
                <td class="pb-5">{{ $neuweg->stock }}</td>
                <td class="pb-5">{{ $bourgfelden->stock }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{ $centre->distribue + $centre->stock }}</td>
                <td>{{ $neuweg->distribue + $neuweg->stock }}</td>
                <td>{{ $bourgfelden->distribue + $bourgfelden->stock }}</td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <a class="btn btn-secondary btn-shadow" href="/gestion/centre" role="button">Gérer le stock</a>
                </td>
                <td>
                    <a class="btn btn-secondary btn-shadow" href="/gestion/neuweg" role="button">Gérer le stock</a>
                </td>
                <td>
                    <a class="btn btn-secondary btn-shadow" href="/gestion/bourgfelden" role="button">Gérer le stock</a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-5">
        <p class="h3 float-right">Total (Tous quartiers confondus) :
            {{ $centre->distribue + $centre->stock + $neuweg->distribue + $neuweg->stock + $bourgfelden->distribue + $bourgfelden->stock }}
            <p>
    </div>
</div>
@endsection
