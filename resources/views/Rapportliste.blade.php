@extends('layouts.master')

@section('content')

    <div>
        <h1>Rapports de visite par médicament</h1>
    </div>

    @if($idMedicament)

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Nom du praticien</td>
                <td>Prénom praticien</td>
                <td>Nom du visiteur</td>
                <td>Prénom visiteur</td>
                <td>Id rapport</td>
                <td>Date du rapport</td>
                <td>Quantité offerte</td>
                <td>Bilan</td>
                <td>Motif</td>
                <td>Médicaments</td>
            </tr>
            </thead>

            @forelse($rapports as $rapport)
                <tr>
                    <td>{{ $rapport->nom_praticien }}</td>
                    <td>{{ $rapport->prenom_praticien }}</td>
                    <td>{{ $rapport->nom_visiteur }}</td>
                    <td>{{ $rapport->prenom_visiteur }}</td>
                    <td>{{ $rapport->id_rapport }}</td>
                    <td>{{ $rapport->date_rapport }}</td>
                    <td>{{ $rapport->qte_offerte }}</td>
                    <td>{{ $rapport->bilan }}</td>
                    <td>{{ $rapport->motif }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('/editRapport/'.$rapport->id_rapport) }}">
                            Médicaments
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Aucun rapport trouvé pour ce médicament.</td>
                </tr>
            @endforelse

        </table>

    @else
        <div class="alert alert-warning">
            Veuillez sélectionner un médicament pour afficher les rapports.
        </div>
    @endif

@endsection
