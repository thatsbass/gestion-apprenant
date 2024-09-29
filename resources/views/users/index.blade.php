@extends('layouts.app')

@section('content')
    <h1>Liste des Utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Fontion</th>
                <th>Adresse</th>
                <th>Rôle</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user['nom'] }}</td>
                    <td>{{ $user['prenom'] }}</td>
                    <td>{{ $user['telephone'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['fonction'] }}</td>
                    <td>{{ $user['adresse'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>{{ $user['statut'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
