@extends('layouts.layout')

@section('title')
Gestion des Stocks
@endsection


@section('content')
<div class="m-5 w-75 m-auto">
    <table class="table m-auto h4 text-center">
        <thead>
            <th scope="col">Quartier</th>
            @foreach ($quartiers as $quartier)
            <th scope="col">{{ $quartier->nom }}</th>
            @endforeach
        </thead>
        <tbody>
            <tr>
                <th>Distribués</th>
                @foreach ($quartiers as $quartier)
                <td>{{ $quartier->distribue }}</td>
                @endforeach
            </tr>
            <tr>
                <th class="pb-5">Restants</th>
                @foreach ($quartiers as $quartier)
                <td class="pb-5">{{ $quartier->stock }}</td>
                @endforeach
            </tr>
            <tr>
                <th>Total</th>
                @foreach ($quartiers as $quartier)
                <td>{{ $quartier->distribue + $quartier->stock }}</td>
                @endforeach
            </tr>
            <tr>
                <th></th>
                @foreach ($quartiers as $quartier)
                <td>
                    <a class="btn btn-secondary btn-shadow" href="/gestion/{{ $quartier->nom }}" role="button">Gérer le
                        stock</a>
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <div class="mt-5">
        @php
        $total = 0
        @endphp
        @foreach ($quartiers as $quartier)
        @php
        $total += $quartier->distribue + $quartier->stock
        @endphp
        @endforeach
        <p class="h3 float-right">Total (Tous quartiers confondus) :
            {{-- {{ $centre->distribue + $centre->stock + $neuweg->distribue + $neuweg->stock + $bourgfelden->distribue + $bourgfelden->stock }}
            --}}
            {{ $total }}
            <p>
    </div>
</div>
@endsection
