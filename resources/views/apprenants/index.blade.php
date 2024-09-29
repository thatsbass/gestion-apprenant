@extends('layouts.app')

@section('content')
    <h1>Liste des Apprenants</h1>

    <a href="{{ route('apprenants.export', ['format' => 'pdf']) }}">Exporter en PDF</a>
    <a href="{{ route('apprenants.export', ['format' => 'excel']) }}">Exporter en Excel</a>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Référentiel</th>
                <th>Compétence</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apprenants as $apprenant)
                <tr>
                    <td>{{ $apprenant->nom }}</td>
                    <td>{{ $apprenant->prenom }}</td>
                    <td>{{ $apprenant->email }}</td>
                    <td>{{ $apprenant->referentiel->libelle }}</td>
                    <td>{{ $apprenant->referentiel->competence->nom }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
