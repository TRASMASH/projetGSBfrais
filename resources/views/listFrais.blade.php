@extends('layouts.master')
@section('content')
    <div>
        <h1>Liste des fiches de Frais </h1>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Mois</th>
            <th>Montant saisi</th>
            <th>Nb justificatifs</th>
            <th>Montant validé</th>
            <th>Etat</th>
            <th>Modifier</th>
        </tr>
        </thead>
        @foreach($fiches as $frais)<tr>
            <td>{{$frais->anneemois}}</td>
            <td>{{$frais->montantSaisi}}</td>
            <td>{{$frais->nbjustificatifs}}</td>
            <td>{{$frais->montantvalide}}</td>
            <td>{{$frais->id_etat}}</td>
            <td><a href="formFrais.blade.php" > modifier </a></td>
        </tr>
        @endforeach

    </table>
@endsection
