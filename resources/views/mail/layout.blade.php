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
</head>

<body>

    <header class="container-fluid d-flex p-3">
        <a href="/"><img src="{{ asset('images/logo-rd.png') }}" alt="Logo Ville de Saint-Louis"
                class="ml-3  d-none d-md-block"></a>

        <h1 class="st-blue m-auto d-none d-sm-block">
            Demande de masques | @yield('title')
        </h1>
    </header>


    <div class="m-5">
        @yield('content')

    </div>


    @yield('script')

</body>

</html>
