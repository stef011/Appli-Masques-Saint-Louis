@extends('layouts.layout')

@section('title')
Ajouter un Utlisiateur
@endsection

@section('content')
<form action="{{ route('admin.add') }}" method="post" class="font m-auto st-blue">
    @csrf
    <label for="login">Identifiant</label>
    <input type="text" name="login" id="login" value="{{ old('login') }}"
        class="form-control @error('login') is-invalid @enderror" required>
    @error('login')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror

    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
        required>
    @error('password')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror

    <label for="password_confirm">Confirmation mot de passse</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
        class="form-control @error('password') is-invalid @enderror" required>
    @error('password')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror

    <label for="role">Rôle</label>
    <select name="role" id="role" class="form-control form-control-lg @error('role') is-invalid @enderror">
        @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}>{{ $role->role }}
        </option>
        @php
        if($role->role == 'distribution'){
        $distId = $role->id;
        }
        @endphp
        @endforeach
    </select>


    <div id="selectionQuartiers" class="d-none @error('quartiers') is-invalid @enderror">
        <h3 class="mt-4 h1">Selectionnez les quartiers</h3>
        @foreach ($quartiers as $quartier)
        <div class="form-check">
            <input type="checkbox" name="quartiers[]" id="quartier{{ $quartier->id }}" value="{{ $quartier->id }}"
                class="line form-check-input"
                {{ old('quartiers') ? (in_array($quartier->id, old('quartiers')) ? 'checked' : '') : '' }}>
            <label for="quartier{{ $quartier->id }}" class="form-check-label">{{ $quartier->nom }}</label>
        </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success btn-shadow float-right mt-5">Créer</button>
</form>
@endsection

@section('script')
<script type="text/javascript">
    var distId = "{{ $distribution->id }}"
    $(document).ready(function () {
        if ($('#role option:selected').val() == distId) {
            $('#selectionQuartiers').removeClass('d-none');
        }
        $("#role").change(function () {
            var role = $(this).children("option:selected").val();
            if (role == distId) {
                $('#selectionQuartiers').removeClass('d-none');
            } else {
                $('#selectionQuartiers').addClass('d-none');
            }
        });
    })

</script>
@endsection
