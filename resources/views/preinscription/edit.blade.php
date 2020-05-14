@extends('layouts.layout')

@section('title')
Modification
@endsection

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- JQuery UI --}}
<link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
@endsection

@section('content')
<div class="m-auto">
    @if (session('success'))
    <p class="alert alert-success w-50 m-auto"> {{ session('success') }} </p>
    @endif
    <div class="mt-5">
        <form action="{{ route('preinscription.edit', ['inscription'=>$inscription->numero]) }}" method="POST"
            class="st-blue mw-10 m-auto d-flex flex-column" style="max-width: 60rem !important;">
            <h2 class="h1 mb-3">Coordonnées du demandeur</h2>
            @if ($errors->any())
            @if ($errors->has('email'))
            <p class="alert alert-danger">Vous êtes déjà inscrit.</p>
            @else
            <p class="alert alert-danger">Le formulaire a mal été rempli</p>
            @endif
            @endif
            @csrf
            @method('PUT')
            <div class="form-row justify-content-between">
                <div class="form-group col-md-5 ">
                    <label for="nom">Nom (Marital)</label>
                    <input required type="text" name="nom" id="nom"
                        value="{{ old('nom',$inscription->citoyens()->first()->nom) }}"
                        class="form-control @error('nom') is-invalid @enderror" required>
                    @error('nom')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-5">
                    <label for="dateNaissance">Date de Naissance</label>
                    <input required type="date" name="date_de_naissance" id="date"
                        value="{{ old('date_de_naissance',$inscription->citoyens()->first()->date_de_naissance) }}"
                        class="form-control @error('date_de_naissance') is-invalid @enderror " required>
                    @error('date_de_naissance')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-row mt-auto justify-content-between">
                <div class="form-group col-md-5">
                    <label for="prenom">Prénom</label>
                    <input required type="text" name="prenom" id="prenom"
                        value="{{ old('prenom', $inscription->citoyens()->first()->prenom) }}"
                        class="form-control @error('prenom') is-invalid @enderror" required>
                    @error('prenom')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group col-md-5">
                    <label for="numero">Adresse</label>
                    <div class="input-group">
                        <input required type="text" name="numero" id="numero"
                            value="{{ old('numero',$inscription->foyer->numero) }}" placeholder="N°" class="form-control col-2 @error('numero')
                            is-invalid @enderror" required>
                        <input type="number" name="rueid" id="rueid"
                            value="{{ old('rueid',$inscription->foyer->rue_id) }}" hidden>
                        <input required type="text" name="rue" id="rue"
                            value="{{ old('rue', $inscription->foyer->rue->nom) }}" placeholder="Rue"
                            class="form-control @error('rueid') is-invalid @enderror"
                            style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;" required>
                        @error('rue')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                        @error('numero')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                        @error('rueid')
                        <p class="invalid-feedback">Veuillez utiliser l'autocomplétion pour compléter le nom de rue</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row mt-auto justify-content-between">
                <div class="form-group col-md-5">
                    <label for="mail">Téléphone</label>
                    <input type="tel" name="tel" id="tel" class="form-control @error('tel') is-invalid @enderror"
                        value="{{ old('tel',$inscription->citoyens()->first()->tel) }}" required>
                    @error('tel')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-5">
                    <label for="Quartier">Point de retrait</label>
                    <select name="quartier" id="quartier" class="form-control @error('quartier') is-invalid @enderror"
                        required>
                        @foreach ($quartiers as $quartier)
                        <option value="{{ $quartier->id }}" @if($inscription->foyer->quartier_id ==
                            $quartier->id)selected @endif>{{ $quartier->nom }}</option>
                        @endforeach
                    </select>
                    @error('quartier')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-row mt-auto justify-content-between">
                <div class="form-group col-md-5">
                    <label for="prioritaire">Prioritaire *</label>
                    <select name="prioritaire" id="prioritaire"
                        class="form-control @error('prioritaire') is-invalid @enderror">
                        <option value="0" @if($inscription->citoyens()->first()->prioritaire ==
                            false) selected @endif>Non</option>
                        <option value="1" @if($inscription->citoyens()->first()->prioritaire ==
                            true) selected @endif>Oui</option>
                    </select>
                    @error('prioritaire')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-text col-md-5 mt-3">
                    <p class="h3">* Vous êtes prioritaire si:
                        <ul class="h4">
                            <li>Vous utilisez les transports en commun</li>
                            <li>Vous êtes personne à risque</li>
                        </ul>
                    </p>
                </div>
            </div>

            <div class="form-row mt-auto justify-content-between">
                <div class="col-md-5">
                    <label for="nb_masques">Nombre de masques (inscription papier)</label>
                    <input type="number" name="nb_masques" id="nb_masques" class="form-control"
                        value="{{ old('nb_masques', $inscription->foyer->nb_masques ) }}">
                </div>
            </div>

            <div class="form-row mt-5 justify-content-between">
                <button type="reset" class="btn btn-shadow btn-danger">Réinitialiser</button>
                <a href="{{ route('preinscription.list') }}" class="btn btn-secondary btn-shadow" role="button">Liste
                    des inscrits</a>
                <button type="submit" class="btn btn-shadow btn-success">Valider</button>
            </div>


        </form>
        <p class="float-right">Etape 1/2</p>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        console.log('salut');
        $("#rue").autocomplete({
            minLength: 1,
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('rues') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        rue: request.term
                    },
                    success: function (data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                // Fill while counting
                $('#rue').val(ui.item.nom);
                console.log(ui.item.id);
                return false;
            },
            select: function (event, ui) {
                // Set selection
                $('#rueid').val(ui.item.id);
                $('#rue').val(ui.item.nom);

                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.nom + "</div>")
                .appendTo(ul);
        };
    });

    // Prevents user to validate the form with enter but add a line instead
    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    });

</script>
@endsection
