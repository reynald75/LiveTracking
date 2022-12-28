@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/interfaces.scss') }}" />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Confirm user deletion') }}</div>
                    <div class="card-body">
                        <div>
                            Are you sure you want to delete user '{{$user->first_name . ' ' . $user->last_name}}'
                        </div>
                        <div style="float: right">
                            <button class="btn btn-secondary" onclick="history.back()">Cancel</button>
                            <form action="{{route('pilot.destroy', $user->id)}}" method="POST" style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-primary" type="submit" title="Delete user">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection