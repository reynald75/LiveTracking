@extends('layouts.app')

@section('content')
    <h1>Ajout d'organisation</h1>

    <form id="orgForm" method="POST" action="{{ action('OrganizationController@store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" name="name">
            <button class="btn btn-primary" type="submit"
                onclick="event.preventDefault();$('#orgForm').submit();">Confirmer</button>
        </div>
    </form>
@endsection
