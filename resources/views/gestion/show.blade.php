@extends('layouts.layout')

@section('title')
Gestion Quartier {{ $quartier->nom }}
@endsection

@section('content')
<div>
    <div class="d-flex justify-content-between">
        <a href="{{ route('gestion.index') }}" class="text-decoration-none text-body h4"><i class="fa fa-chevron-left"
                aria-hidden="true"></i> Retour</a>

        <h2 class="m-auto h1">{{ $quartier->nom }} | Gestion du Stock</h2>
    </div>
    <div class="m-5">
        <div class=" w-75 mt-5 m-auto d-flex justify-content-between">
            <p class="h3">Masques Disponibles : {{ $quartier->stock }}</p>
            <p class="h3">Masques Distribués : {{ $quartier->distribue }}</p>
            <p class="h3 text-bold">Total : {{ $quartier->distribue + $quartier->stock }}</p>
        </div>
    </div>
    <div class="mt-10">
        <form action="{{ route('gestion.post', ['quartier'=>$quartier->nom]) }}" method="POST"
            class="form-inline m-auto">
            @csrf
            <div class="form-group m-auto">
                <label for="stockAdd" class="col-lg-10">Ajouter du stock au quartier {{ $quartier->nom }} </label>
                <div class="col-lg-2">
                    <input type="number" id="stockAdd" name="stockAdd"
                        class="form-control @error('stockAdd') is-invalid @enderror">
                </div>
            </div>


            <div id="validateStock">
                <button type="submit" class="btn btn-success btn-lg btn-shadow">Valider</button>
            </div>
        </form>

        <div id="cancelStock">
            <a href="{{ route('gestion.index') }}" class="btn btn-danger btn-shadow btn-lg"> Annuler</a>
        </div>
    </div>

</div>
@endsection
