@extends('layouts.master')

@section('content')

    <div>
        <h1>Liste des médicaments</h1>
    </div>
    <form method="POST" action="{{ url('/rapportParMedoc') }}" class="col-md-12 card card-body bg-light">
        @csrf
    <select name="id_medicament" class="form-control" required>
        @foreach($medicaments as $medoc)
            <option value="{{$medoc-> id_medicament}}">
                {{ $medoc->nom_commercial }}
            </option>
        @endforeach
    </select>
    <div class="form-group row">
        <div class="col-md-12 offset-md-3">
            <button type="submit" class="btn btn-primary">Valider</button>

        </div>
    </div>
    </form>
@endsection

url('/rapportParMedoc?id_medicament='.$medoc->id_medicament)
