@extends('layouts.master')

@section('content')

    <h1>Ajouter un médicament offert</h1>

    <form method="post" action="{{ url('/saveOffert') }}">
        @csrf

        <input type="hidden" name="id_rapport" value="{{ $id_rapport }}">

        <div class="mb-3">
            <label>Médicament :</label>
            <select name="id_medicament" class="form-control">
                @foreach($medicaments as $m)
                    <option value="{{ $m->id_medicament }}">
                        {{ $m->nom_commercial }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Quantité offerte :</label>
            <input type="number" name="qte_offerte" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="{{ url('/editRapport/'.$id_rapport) }}" class="btn btn-secondary">Annuler</a>
    </form>

@endsection
