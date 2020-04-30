@extends('layouts.layout')

@section('title')
Quartier {{ $quartier->nom }}
@endsection

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- JQuery UI --}}
{{-- <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script> --}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
<div class="w-75 m-auto">
    <div class="mt-5">
        <form action="{{ route('distribution.demande', ['quartier'=> $quartier->id]) }}" method="POST"
            class="st-blue w-75 m-auto d-flex flex-column">
            @csrf
            <div class="form-row justify-content-between">
                <div class="form-group col-md-5 ">
                    <label for="nom">Nom</label>
                    <input required type="text" name="nom" id="nom" class="form-control form-control-lg">
                </div>
                <div class="form-group col-md-5">
                    <label for="dateNaissance">Date de Naissance</label>
                    <input required type="date" name="dateNaissance" id="date" class="form-control form-control-lg">
                </div>
            </div>
            <div class="form-row mt-auto justify-content-between">
                <div class="form-group col-md-5">
                    <label for="prenom">Prénom</label>
                    <input required type="text" name="prenom" id="prenom" class="form-control form-control-lg">
                </div>

                <div class="form-group col-md-5">
                    <label for="numero">Adresse</label>
                    <div class="input-group">
                        <input required type="text" name="numero" id="numero" placeholder="N°"
                            class="form-control form-control-lg col-2">
                        <input required type="text" name="rue" id="rue" placeholder="Rue"
                            class="form-control form-control-lg"
                            style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;">
                    </div>
                </div>
            </div>
            <div class="form-row mt-5 justify-content-between">
                <button type="reset" class="btn btn-shadow btn-danger">Réinitialiser</button>
                <button type="submit" class="btn btn-shadow btn-success">Valider</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        $("#nom").autocomplete({
            minLength: 1,
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('citoyens') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        nom: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                // Fill while compting
                $('#nom').val(ui.item.nom);
                $('#prenom').val(ui.item.prenom);
                $('#date').val(ui.item.dob);
                $('#numero').val(ui.item.numero);
                $('#rue').val(ui.item.rue);
                return false;
            },
            select: function (event, ui) {
                // Set selection
                $('#nom').val(ui.item.nom);
                $('#prenom').val(ui.item.prenom);
                $('#date').val(ui.item.dob);
                $('#numero').val(ui.item.numero);
                $('#rue').val(ui.item.rue);

                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.nom + " " + item.prenom + " " + item.dob + "</div>")
                .appendTo(ul);
        };

    });

</script>

@endsection
