@extends('layouts.master')

@section('content')
    <h1>Le top des médicaments les plus offerts</h1>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Classement</th>
            <th>Médicament</th>
            <th>Total offert</th>
        </tr>
        </thead>

        <tbody>
        @php $classement = 1; @endphp

        @foreach($medicaments as $med)
            <tr>
                <td>{{ $classement }}</td>
                <td>{{ $med->nom_commercial }}</td>
                <td>{{ $med->total_offert }}</td>
            </tr>

            @php $classement++; @endphp
        @endforeach
        </tbody>
    </table>
@endsection
