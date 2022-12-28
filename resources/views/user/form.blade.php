@extends('layouts.app')

@php
    use App\Models\Organization;
    use App\Models\User;
    use Spatie\Permission\Models\Role;
    
    $editMode = isset($user);
    
    if ($editMode) {
        $org = Organization::find($user->organization_id);
    } else {
        $org = Organization::where('ref_uuid', $org_id)
            ->get()
            ->first();
    }
@endphp

@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/interfaces.scss') }}" />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ($editMode ? 'Edit' : 'Create') . ' user' }}</div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ $editMode ? route('pilot.update', $user->id) : route('pilot.register') }}">
                            @csrf
                            <input type="hidden" name="_method" value="{{ $editMode ? 'PATCH' : 'POST' }}" />

                            @if ($editMode)
                                <input type="hidden" name="_user_id" value="{{ $user->id }}" />
                            @endif

                            <div class="row mb-3">
                                <label for="first_name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name', $user->first_name ?? null) }}" required
                                        autocomplete="name" autofocus>

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Last name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name', $user->last_name ?? null) }}" required
                                        autocomplete="name" autofocus>

                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="initials"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Initials') }}</label>

                                <div class="col-md-6">
                                    <input id="initials" type="text"
                                        class="form-control @error('initials') is-invalid @enderror" name="initials"
                                        value="{{ old('initials', $user->initials ?? null) }}" maxlength="2" required
                                        autocomplete="initials" autofocus>

                                    @error('initials')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email ?? null) }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="organization"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Organization') }}</label>

                                <div class="col-md-6">
                                    <input name="organization" class="form-control" value="{{ $org->name }}" disabled>
                                    <input name="org_id" type="hidden" value="{{ $org->id }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="line_color"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Color') }}</label>

                                <div class="col-md-6">
                                    <input type="color" id="line_color" name="line_color"
                                        value="{{ old('line_color', $user->line_color ?? '#000000') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="roles"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Roles') }}</label>

                                <div class="col-md-6">
                                    <fieldset>
                                        @foreach (Role::all() as $role)
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                {{ isset($user) ? ($user->hasRole($role->name) ? 'checked' : '') : '' }}>
                                            {{ ucfirst(preg_replace('/([a-z0-9])([A-Z])/', "$1 $2", $role->name)) }}<br>
                                        @endforeach
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-secondary" onclick="history.back()">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ $editMode ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
