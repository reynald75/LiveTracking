@extends('layouts.app')

@section('content')
    <h1>Add organization</h1>

    <form id="orgForm" method="POST" action="{{ action('OrganizationController@store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name">
            <button class="btn btn-primary" type="submit"
                onclick="event.preventDefault();$('#orgForm').submit();">Confirm</button>
        </div>
    </form>
@endsection
