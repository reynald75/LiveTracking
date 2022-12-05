@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/interfaces.scss') }}" />
    <div>
        @hasrole('siteAdmin')
            <button class="btn btn-primary" id="orgAdd">
                <a href="{{ URL::to('organization/create') }}">
                    <x-fas-users-rays /> Ajouter organisation
                </a>
            </button>
        @endhasrole
    </div>
    <div class="accordion">
        @foreach ($data as $org)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $org->id }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $org->id }}" aria-expanded="true"
                        aria-controls="collapse{{ $org->id }}">
                        <x-fas-users-rays /> Organisation: {{ $org->name }}
                    </button>
                </h2>
                <div id="collapse{{ $org->id }}" class="accordion-collapse collapse show"
                    aria-labelledby="heading{{ $org->id }}">
                    <div class="accordion-body">
                        <!--Users in organization-->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nom</td>
                                    <td>Initiales</td>
                                    <td>E-mail</td>
                                    <td>Couleur</td>
                                    <td>Role(s)</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($org->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->initials }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="userColorSwatch" style="background-color: {{ $user->line_color }}">
                                            </div>
                                            {{ $user->line_color }}
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                {{$role->name}}
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="ActionContainer">
                                                <button class="Action">
                                                    <a href="{{ URL::to('/api/pilot/edit/' . $user->id ) }}">
                                                        <x-fas-user-pen />
                                                    </a>
                                                </button>
                                                <form action="{{route('pilot.destroy', $user->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="Action" type="submit">
                                                        <x-fas-user-slash />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary" id="userAdd">
                            <a href="{{ URL::to('pilots/create') }}">
                                <x-fas-user-plus /> Ajouter utilisateur
                            </a>
                        </button>
                    </div>
                </div>
            </div>
            @if ($org != $data[count($data)-1])
                <hr/>
            @endif
        @endforeach
    </div>
@endsection
