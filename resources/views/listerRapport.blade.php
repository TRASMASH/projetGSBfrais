@extends('layouts.master')

@section('content')
    <div>
        <h1>Liste des rapport par praticien  </h1>
    </div>
    <form method="GET" action="{{ url('/listerRapport') }}" class="mb-4">

        <div class="row">

            <div class="col-md-4">
                <label>Nom du praticien :</label>
                <input type="text" name="nom" class="form-control" value="{{ request('nom') }}">
            </div>

            <div class="col-md-4">
                <label>Date du rapport :</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Rechercher</button>
                <a href="{{ url('/listerRapport') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>

        </div>

    </form>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <td>Nom du praticien</td>
            <td>Prénom praticien</td>
            <td>Id rapport</td>
            <td>Date du rapport</td>
            <td>Bilan</td>
            <td>Motif</td>
            <td>Médicaments</td>
        </tr>
        </thead>

        @foreach($fiches as $rapport)
            <tr>
                <td>{{ $rapport->nom_praticien }}</td>
                <td>{{ $rapport->prenom_praticien }}</td>
                <td>{{ $rapport->id_rapport }}</td>
                <td>{{ $rapport->date_rapport }}</td>
                <td>{{ $rapport->bilan }}</td>
                <td>{{ $rapport->motif }}</td>

                <td>
                    <a class="btn btn-primary" href="{{ url('/editRapport/'.$rapport->id_rapport) }}">
                        Médicaments
                    </a>
                </td>
            </tr>
        @endforeach

    </table>


    </table>
@endsection
