@extends('layouts.layout')

@section('title')
Modification
@endsection

@section('hidden')
hidden
@endsection

@section('content')
<div class="mw-10 m-auto">
    <form action="{{ route('inscription.get') }}" method="post">

        @if (session('success'))
        <p class="alert alert-danger">{{ session('success') }}</p>

        @endif

        @csrf
        <label for="code">Code d'inscription</label>
        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror">
        <small class="form-text text-muted mb-2">Ce code est celui qui vous a été donné lors de votre inscription et
            envoyé
            par mail.</small>
        @error('code')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn-primary btn-shadow">Valider</button>
    </form>
</div>
@endsection
