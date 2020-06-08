@extends('layouts.layout')

@section('title')
Accueil
@endsection

@section('head')
<meta http-equiv="refresh" content="20;url=https://www.saint-louis.fr/Accueil+minisite+Saint_Louis/373/16002" />
@endsection

@section('content')
<div class="mw-10 m-auto">
    {{-- <h2 class="h1">Distribution gratuite de masques homologués à la population.</h2>
    <a href="{{ route('inscription.index') }}" class="btn btn-primary btn-shadow mt-5 btn-lg ">Se pré-inscrire à la
    Distribution</a>
    <a href="{{ route('inscription.get') }}" class="btn btn-primary btn-shadow mt-5 btn-lg">Modifier mon inscription</a>
    --}}
    <div class="m-auto">
        <h2 class="h1">Les inscriptions ont été clôturées, vous allez être redirigé dans
            <span id="counter"></span> secondes
        </h2>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    var countDownDate = new Date();
    countDownDate.setSeconds(countDownDate.getSeconds() + 20);
    countDownDate = countDownDate.getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("counter").innerHTML = seconds;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("counter").innerHTML = "0";
        }

    }, 1000);

</script>
@endsection
