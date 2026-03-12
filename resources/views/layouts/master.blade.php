<!doctype html>
<html lang="fr">

<head>
    <title>GSB Frais</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/gsb.css"/>

</head>

<body class="body">
<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">GSBfrais</a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/listerFrais') }}">Lister</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/ajouterFrais') }}">Ajouter</a>
                    </li>
                    <li><a class="nav-link" href="{{url('listerRapport')}}"> liste des rapport</a> </li>
                    <li> <a class="nav-link" href="{{ url('/rechercherRapport') }}">Rechercher</a> </li>
                    <li><a class="nav-link" href="{{url('/ajouterRapport')}}">Ajouter un rapport </a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/topMedicaments') }}">Top Médicaments</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a @if(session(('id_visiteur'))) class="nav-link" href="{{ url('/deconnecter') }}"> ({{session('visiteur')}})Se déconnecter</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" @else href="{{ url('/connecter') }}">Se connecter</a>
                    </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>

</div>
<div class="container">
    @yield('content')
</div>
<script src="/assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>
