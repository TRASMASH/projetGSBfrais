@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h1>Ajouter un rapport de visite</h1>

        <form method="POST" action="{{ url('ajouterRapport') }}" class="col-md-12 card card-body bg-light">
            @csrf

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label">Date de la visite</label>
                <div class="col-md-6">
                    <input type="date" name="date_rapport" class="form-control" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label">Motif de la visite</label>
                <div class="col-md-6">
                    <input type="text" name="motif" class="form-control" placeholder="Ex: Présentation nouveauté..." required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label">Bilan de la visite</label>
                <div class="col-md-6">
                    <textarea name="bilan" class="form-control" rows="4" placeholder="Résumé de l'entrevue..." required></textarea>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label">Praticien</label>
                <div class="col-md-6">
                    <select name="id_praticien" class="form-control" required>
                        <option value="" disabled selected>-- Choisissez un praticien --</option>

                        @foreach($praticiens as $unPraticien)
                            <option value="{{ $unPraticien->id_praticien }}">
                                {{ $unPraticien->nom_praticien }} {{ $unPraticien->prenom_praticien }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-12 offset-md-3">
                    <button type="submit" class="btn btn-primary">Valider</button>
                    <a href="{{ url('/') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </div>
        </form>

        @if(isset($erreur))
            <div class="alert alert-danger mt-3" role="alert">{{ $erreur }}</div>
        @endif
    </div>
@endsection
