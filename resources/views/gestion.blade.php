@extends('layouts.layout')

@section('title')
Gestion des Stock
@endsection


@section('content')
<div class="m-5">
    <table class="table w-75 m-auto h4">
        <thead>
            <th scope="col">Quartier</th>
            <th scope="col">Centre</th>
            <th scope="col">Neuweg</th>
            <th scope="col">Bourgfelden</th>
        </thead>
        <tbody>
            <tr>
                <th>Distribués</th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Restants</th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <a class="btn btn-secondary" href="/gestion/centre" role="button">Gérer le stock</a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="/gestion/neuweg" role="button">Gérer le stock</a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="/gestion/bourgfelden" role="button">Gérer le stock</a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mr-5 mt-5 w-75">
        <p class="h3 float-right">Total (Tous sites confondus) : <p>
    </div>
</div>
@endsection
