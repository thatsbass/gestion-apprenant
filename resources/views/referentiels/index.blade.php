@extends('layouts.app')

@section('content')
    <h1>Liste des Référentiels</h1>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Libelle</th>
                <th>Description</th>
                <th>Etat</th>
                <th>Competences</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($referentiels as $referentiel)
                <tr>
                    <td>{{ $referentiel['code'] }}</td>
                    <td>{{ $referentiel['libelle'] }}</td>
                    <td>{{ $referentiel['description'] }}</td>
                    <td>{{ $referentiel['statut'] }}</td>
                    <td>
                        @foreach ($referentiel['competences'] as $competence)
                            {{ $competence['nom'] }},
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
