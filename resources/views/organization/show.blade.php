@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/interfaces.scss') }}" />
    <div>
        @hasrole('siteAdmin')
            <button class="btn btn-primary" id="orgAdd">
                <a href="{{ URL::to('organization/create') }}">
                    <x-fas-users-rays /> Add organization
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
                        <x-fas-users-rays /> Organization: {{ $org->name }}
                    </button>
                </h2>
                <div id="collapse{{ $org->id }}" class="accordion-collapse collapse show"
                    aria-labelledby="heading{{ $org->id }}">
                    <div class="accordion-body">
                        <span class="btn btn-primary" id="orgLink" onclick="navigator.clipboard.writeText(window.location.origin + '?' + 'org_id=' + '{{ $org->ref_uuid }}');">
                            Copy map link
                        </span>
                        <span>Organization id: {{ $org->ref_uuid }}</span>
                        <!--Users in organization-->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Initials</td>
                                    <td>E-mail</td>
                                    <td>Color</td>
                                    <td>Role(s)</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($org->users as $user)
                                    <tr>
                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                        <td>{{ $user->initials }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="userColorSwatch" style="background-color: {{ $user->line_color }}">
                                            </div>
                                            {{ $user->line_color }}
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                {{ ucfirst(preg_replace( '/([a-z0-9])([A-Z])/', "$1 $2", $role->name))}}
                                                {{ ($role != $user->roles[count($user->roles) - 1] ? '/' : '') }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="actionContainer">
                                                <button class="action" title="Edit user">
                                                    <a href="{{route('pilot.edit', $user->id)}}">
                                                        <x-fas-user-pen />
                                                    </a>
                                                </button>
                                                <button class="action" title="Edit user">
                                                    <a href="{{route('pilot.confirm_destroy', $user->id)}}">
                                                        <x-fas-user-slash />
                                                    </a>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary" id="userAdd">
                            <a href="{{ URL::to('pilots/create/') . '/' . $org->ref_uuid }}">
                                <x-fas-user-plus /> Add user
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
