@extends('layouts.layout')


@section('title')
{{ $citoyen->nom . ' ' . $citoyen->prenom }}
@endsection

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- JQuery UI --}}
<link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.min.css') }}">
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
@endsection

{{-- {{ dd(route('distribution.create', ['quartier'=>$quartier->id])) }} --}}

@section('content')
<div class="m5">
    <form method="post" action="{{ route('distribution.create', ['quartier'=>$quartier->id]) }}"
        class="w-75 m-auto table-responsive">
        @csrf

        <table class="table table-striped table-bordered m-auto h5 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Date de Naissance</th>
                    <th>Masque</th>
                </tr>
            </thead>
            <tbody id="lignes">
                @php
                $ids = array();
                @endphp
                @foreach ($membres as $key=>$membre)

                <tr {!! $membre->date_de_demande == NULL ? '' : 'class="table-danger"' !!}>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $membre->nom }}</td>
                    <td>{{ $membre->prenom }}</td>
                    <td>{{ date('d-m-Y', strtotime($membre->date_de_naissance)) }}</td>
                    <td><input type="checkbox" name="citoyens[]" id="check{{ $key + 1 }}" value="{{ $membre->id }}"
                            {{ $membre->date_de_demande == NULL ? 'checked' : 'disabled'}}>
                        @if ($membre->date_de_demande != NULL)
                        <button type="button" class="btn btn-warning btn-shadow btn-sm" id="button{{ $key+1 }}"
                            onclick="$('#check{{ $key+1 }}').removeAttr('disabled'); $('#button{{ $key+1 }}').attr('hidden', true)">Dévérrouiller</button>
                        @endif

                    </td>
                </tr>
                @php
                array_push($ids,$membre->id);
                @endphp

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th style="vertical-align: middle">
                        <i class="fa fa-plus my-auto" aria-hidden="true"></i>
                    </th>
                    <td><input type="text" name="nom" id="nom" class="form-control"></td>
                    <td><input type="text" name="prenom" id="prenom" class="form-control"></td>
                    <td><input type="text" name="dateNaissance" id="dateNaissance" class="form-control"></td>
                    <td>
                        <input type="number" name="id" id="id" hidden> <button class="btn btn-success btn-shadow"
                            id='process' type="button" onclick="addRow();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-5">
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
            <button type="submit" class="btn btn-success ">Valider</button>
        </div>
    </form>
</div>
@endsection


@section('script')
<script type="text/javascript">
    var ids = "{{ json_encode($ids)  }}"
    var lines = "{{ $membres->count() }}"
    ids = JSON.parse(ids);
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
                        ids.forEach(id => {
                            delete data[id];
                        });
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                // Fill while compting
                $('#nom').val(ui.item.nom);
                $('#prenom').val(ui.item.prenom);
                $('#dateNaissance').val(ui.item.dob);
                return false;
            },
            select: function (event, ui) {
                // Set selection
                $('#id').val(ui.item.id);
                $('#nom').val(ui.item.nom);
                $('#prenom').val(ui.item.prenom);
                $('#date').val(ui.item.dob);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.nom + " " + item.prenom + " " + item.dob + "</div>")
                .appendTo(ul);
        };
    });

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
                    if (data == 1) {
                        masque = true;
                    } else {
                        masque = false;
                    }
                    ids.push($('#id').val());
                    console.log('Ajax Récupéré')
                    lines++;
                    markup = "<tr" + (masque == true ? ' class="table-danger"' : '') +
                        "><td>" + lines +
                        "</td><td>" + $('#nom').val() +
                        "</td><td>" + $('#prenom').val() +
                        "</td><td>" + $('#dateNaissance').val() +
                        "</td><td> <input type='checkbox' name='citoyens[]' id='check" + lines +
                        "' value='" + $(' #id').val() + "'" + (masque != true ?
                            'checked' : 'disabled') +
                        ">" + (masque == true ?
                            '<button class="btn btn-warning btn-shadow btn-sm" id="button' + lines +
                            '" type="button" onClick="$(\'#check' + lines +
                            '\').removeAttr(\'disabled\'); $(\'#button' + lines +
                            '\').attr(\'hidden\', true)">Dévérrouiller</button>' :
                            '') +
                        "</td></tr>";
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

@endsection
