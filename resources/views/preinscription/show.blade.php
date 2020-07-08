@extends('layouts.layout')

@section('title')
{{ $citoyen->prenom . " " . $citoyen->nom }}
@endsection


@section('content')
<div class="m5">
    <h2>Ajout des membres du foyer</h2>
    <form method="post"
        action="{{ Auth::user()->role->role == 'preinscription' ? route('preinscription.add') : route('distribution.add') }}"
        class="m-auto table-responsive" style="max-width: 150rem">
        @csrf

        @if (session('success'))
        <p class="alert-danger alert">{{ session('success') }}</p>
        @endif

        <table class="table table-striped table-bordered m-auto h5 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Date de Naissance</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="lignes">
                @foreach ($membres as $key=>$membre)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $membre->nom }}</td>
                    <td>{{ $membre->prenom }}</td>
                    <td>{{ date('d-m-Y', strtotime($membre->date_de_naissance)) }}</td>

                    </td>
                    <td>
                        @if($key !=0)
                        <a href="{{ route(Auth::user()->role->role == 'preinscription' ? 'preinscription.remove' : 'distribution.remove', ['membre'=>$key]) }}"
                            type='button' class="btn btn-danger btn-shadow"><i class="fa fa-trash"
                                aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th style="vertical-align: middle">
                        <i class="fa fa-plus my-auto" aria-hidden="true"></i>
                    </th>
                    <td><input type="text" name="nom" id="nom" class="form-control @error('nom') is-error @enderror"
                            required></td>
                    <td><input type="text" name="prenom" id="prenom"
                            class="form-control @error('prenom') is-error @enderror" required></td>
                    <td><input type="date" name="dateNaissance" id="dateNaissance"
                            class="form-control @error('dateNaissance') is-error @enderror" required></td>
                    <td>
                        <button class="btn btn-success btn-shadow" id='process' type="submit">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-5">
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
            <a href="{{ Auth::user()->role->role == 'preinscription' ? route('preinscription.confirm') : route('distribution.confirm') }}"
                type="button" class="btn btn-success btn-shadow">
                {{ Auth::user()->role->role == 'distribution' ? 'Valider et Distribuer' : 'Valider et Terminer' }}
            </a>
        </div>
        <p class="float-right">Etape 2/2</p>
    </form>
</div>
@endsection


{{-- @section('script')
<script type="text/javascript">
    function addRow() {
        var data;
        var masque;


        if ($('#nom').val() && $('#prenom').val() && $('#dateNaissance').val()) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('citoyen') }}",
type: 'post',
data: {
id: $('#id').val()
},
success: function (data) {
lines++;
markup = "<tr" + (masque==true ? ' class="table-danger"' : '' ) + "><td>" + lines + "</td><td>" + $('#nom').val()
    + "</td><td>" + $('#prenom').val() + "</td><td>" + $('#dateNaissance').val()
    + "</td><td> <input type='checkbox' name='prioritaire[]' id='check" + lines + "' value='true'" + (masque !=true
    ? 'checked' : 'disabled' ) + ">" + (masque==true ? '<button class="btn btn-warning btn-shadow btn-sm" id="button' +
    lines + '" type="button" onClick="$(\' #check' + lines + '\' ).removeAttr(\'disabled\'); $(\'#button' + lines + '\'
    ).attr(\'hidden\', true)">Dévérrouiller</button>' :
    '') +
    "</td>
    </tr>";
    $('table tbody').append(markup);
    $('#nom').val('');
    $('#prenom').val('');
    $('#dateNaissance').val('');
    }
    });
    }
    }


    // Prevents user to validate the form with enter but add a line instead
    $(document).ready(function () {
    $(window).keydown(function (event) {
    if (event.keyCode == 13) {
    event.preventDefault();
    addRow();
    }
    });
    });

    </script>

    @endsection --}}
