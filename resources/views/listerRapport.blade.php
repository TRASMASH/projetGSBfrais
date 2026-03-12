@extends('layouts.master')

@section('content')
    <div>
        <h1>Liste des rapport par praticien  </h1>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <td>nom du praticien </td>
            <td>prénom praticien </td>
            <td>Id rapport</td>
            <td>Date du rapport </td>
            <td>Bilan</td>
            <td>Motif</td>
        </tr>
        </thead>
        @foreach($fiches as $rapport)<tr>
            <th><{{$rapport->nom_praticien}}</th>
            <th>{{$rapport->prenom_praticien}}</th>
            <th>{{$rapport->id_rapport}}</th>
            <th>{{$rapport->date_rapport}}</th>
            <th>{{$rapport->bilan}}</th>
            <th>{{$rapport->motif}}</th>
            <th>
                <a class="btn btn-primary" href="{{ url('/editRapport/'.$rapport->id_rapport) }}">
                    Médicaments
                </a>
            </th>

        </tr>
        @endforeach

    </table>
@endsection
