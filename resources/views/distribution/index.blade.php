@extends('layouts.layout')

@section('title')
Choix du quartier
@endsection

@section('content')

<div>
    <h2 class="h1 m-auto w-50">Veuillez choisir un quartier de distribution</h2>

    <div class="mt-5">
        <div class="list-group w-50 m-auto">
            @foreach ($quartier as $quartier)
            <a href="{{ route('distribution.show', ['quartier'=>$quartier->id]) }}"
                class="list-group-item text-decoration-none d-flex justify-content-between align-items-center">
                <span class="h3">
                    {{ $quartier->nom }}
                </span>
                <span class="badge-info badge-pill">Masques restants: {{ $quartier->stock }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
