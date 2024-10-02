@extends('layouts.app')

@section('content')
    <h1>Liste des Promotions</h1>

    <form action="{{ route('promos.index') }}" method="GET">
        <select name="etat">
            <option value="">Filtrer par état</option>
            <option value="Actif">Actif</option>
            <option value="Cloturer">Clôturé</option>
            <option value="Inactif">Inactif</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <a href="{{ route('promos.export', ['format' => 'pdf']) }}">Exporter en PDF</a>
    <a href="{{ route('promos.export', ['format' => 'excel']) }}">Exporter en Excel</a>

    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Durée</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promos as $promo)
                <tr>
                    <td>{{ $promo->libelle }}</td>
                    <td>{{ $promo->date_debut }}</td>
                    <td>{{ $promo->date_fin }}</td>
                    <td>{{ $promo->duree }} mois</td>
                    <td>{{ $promo->etat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
