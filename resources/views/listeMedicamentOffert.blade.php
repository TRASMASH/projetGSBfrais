@extends('layouts.master')

@section('content')

    <h1>Médicaments offerts pour le rapport n°{{ $rapport->id_rapport }}</h1>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Médicament</th>
            <th>Quantité offerte</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>

        <tbody>
        @foreach($offerts as $o)
            <tr>
                <td>{{ $o->nom_commercial }}</td>
                <td>{{ $o->qte_offerte }}</td>

                <td>
                    <a class="btn btn-warning"
                       href="{{ url('/modifierOffert/'.$rapport->id_rapport.'/'.$o->id_medicament) }}">
                        Modifier
                    </a>
                </td>

                <td>
                    <a class="btn btn-danger"
                       href="{{ url('/supprimerOffert/'.$rapport->id_rapport.'/'.$o->id_medicament) }}">
                        Supprimer
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn btn-success mb-3" href="{{ url('/ajouterOffert/'.$rapport->id_rapport) }}">
        Ajouter un médicament
    </a>


@endsection

