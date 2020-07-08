@extends('layouts.layout')

@section('title')
Admin
@endsection

@section('content')
<div class="container-fluid mw-100">
    @if (session('success'))
    <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <table class="table mx-auto table-responsive-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Login</th>
                <th>Mot de passe</th>
                <th>Gérer</th>
            </tr>
        </thead>
        <tbody>
            @php
            $key = 1;
            @endphp
            @foreach($users as $user)
            <tr {{ Auth::user()->id == $user->id ? 'class=table-primary' : '' }}>
                <td scope="row">{{ $key }}</td>
                <td>{{ $user->login }}</td>
                <td><a href="{{ route('admin.password', ['user'=>$user->id]) }}"
                        class="btn btn-danger btn-shadow">Changer le mot de passe</a></td>

                @if (Auth::user()->id != $user->id)
                <td><a href="{{ route('admin.edit', ['user'=>$user->id]) }}"
                        class="btn btn-warning btn-shadow">Gérer</a></td>
                @else
                <td></td>
                @endif
            </tr>
            @php
            $key++;
            @endphp
            @endforeach
            <tr>
                <td scope="row"><a href="{{ route('admin.add') }}" class="btn btn-success btn-shadow"><i
                            class="fa fa-plus" aria-hidden="true"></i></a></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
