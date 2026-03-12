@extends('layouts.master')

@section('content')

    <h1>Modifier médicament offert</h1>

    <form method="post" action="{{ url('/saveModifierOffert') }}">
        @csrf

        <input type="hidden" name="id_rapport" value="{{ $offert->id_rapport }}">
        <input type="hidden" name="id_medicament" value="{{ $offert->id_medicament }}">

        <div class="mb-3">
            <label>Médicament :</label>
            <input type="text" class="form-control" value="{{ $medicament->nom_commercial }}" disabled>
        </div>

        <div class="mb-3">
            <label>Quantité offerte :</label>
            <input type="number" name="qte_offerte" class="form-control" value="{{ $offert->qte_offerte }}">
        </div>

        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

@endsection

