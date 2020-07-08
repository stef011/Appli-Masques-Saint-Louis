<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Distribution de masques Ville de Saint-Louis</title>

    <link rel="icon" href="{{ asset('images/logo-stLouis.png') }}" type="image/png">

    {{-- Bootstrap Files
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.js') }}"></script> --}}
    {{-- jQuerry --}}
    <script src="{{ asset('js/jQuerry.js') }}"></script>

    {{-- Fontawesome Files --}}
    <link rel="stylesheet" href="{{ asset('Fontawesome/css/all.min.css') }}">
    <script src="{{ asset('Fontawesome/js/all.min.js') }}"></script>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('head')
</head>

<body>

    <header class="container-fluid d-flex p-3">
        <a href="/"><img src="{{ asset('images/logo-rd.png') }}" alt="Logo Ville de Saint-Louis"
                class="ml-3  d-none d-md-block"></a>

        <h1 class="st-blue m-auto d-none d-sm-block">
            Demande de masques | @yield('title')
        </h1>

        @auth

        <div>
            <p class="h4 d-inline mr-3">Connecté en tant que <span
                    class="font-weight-bold">{{ Auth::user()->login }}</span></p>
            <a href="{{ route('logout') }}" class="btn btn-lg btn-light btn-shadow">Déconnexion</a>
            @if (Auth::user()->quartiers->filter(function ($item)
            {
            return strtolower($item['nom']) == strtolower('Police Municipale');
            })->first() != null)
            <p class="h3">Masques distribués :
                {{ Auth::user()->quartiers->filter(function ($item)
            {
            return strtolower($item['nom']) == strtolower('police municipale');
            })->first()->distribue}}
            </p>
            @endif
        </div>
        @endauth
        @guest
        <div>
            <a href="{{ route('login') }}" class="btn btn-primary btn-shadow mt5 btn-lg " @yield('hidden')>Se
                Connecter</a>
        </div>
        @endguest


    </header>


    <div class="m-5">
        @yield('content')

    </div>


    @yield('script')

    <footer class="m-4 position-absolute" style="bottom: 0; left: 0; right: 0;">
        <div class="float-right">
            <a href="{{ route('rgpd') }}">Traitements des données</a>
        </div>
    </footer>

</body>

</html>
