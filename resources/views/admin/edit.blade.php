@extends('layouts.layout')

@section('title')
Ajouter un Utlisiateur
@endsection

@section('content')
<form action="{{ route('admin.update',['user'=>$user->id]) }}" method="post" class="font m-auto st-blue">
    @csrf
    @method('PUT')

    <label for="login">Identifiant</label>
    <input type="text" name="login" id="login" value="{{ old('login') ?? $user->login }}"
        class="form-control @error('login') is-invalid @enderror" required>
    @error('login')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror

    <label for="role">Rôle</label>
    <select name="role" id="role" class="form-control form-control-lg @error('role') is-invalid @enderror">
        @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ $role->id == $user->role->id ? 'selected' : '' }}>{{ $role->role }}
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
                class="line form-check-input" {{ $user->quartiers->contains($quartier) ? 'checked' : '' }}>
            <label for="quartier{{ $quartier->id }}" class="form-check-label">{{ $quartier->nom }}</label>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ route('admin.delete', ['user'=>$user->id]) }}"
            onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
            class="btn btn-danger btn-shadow">Supprimer</a>
    </div>
    <div class="d-flex justify-content-between mt-5">
        <a href="{{ URL::previous() }}" class="btn btn-danger btn-shadow">Annuler</a>
        <button type="submit" class="btn btn-success btn-shadow float-right">Modifier</button>
    </div>
</form>
@endsection

@section('script')
<script type="text/javascript">
    var distId = "{{ $role -> distId }}";
    var rolenum = "{{ $distribution->id }}"
    $(document).ready(function () {
        if ($('#role option:selected').val() == 3) {
            $('#selectionQuartiers').removeClass('d-none');
        }
        $("#role").change(function () {
            var role = $(this).children("option:selected").val();
            if (role == 4) {
                $('#selectionQuartiers').removeClass('d-none');
            } else {
                $('#selectionQuartiers').addClass('d-none');
            }
        });
    })

</script>
@endsection
