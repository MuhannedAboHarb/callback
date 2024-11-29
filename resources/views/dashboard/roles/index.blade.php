@extends('layouts.dashboard')
@section('title', __('Roles'))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item light">{{ __('Roles') }}</li>
@endsection

@section('content')
    @can('roles.view')
        <x-flash-message name="success" />

        <div class="table-toobar row mb-3 d-flex justify-content-between">
            <div class="">
                <form action="{{ route('dashboard.roles.index') }}" class="d-flex" method="get">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="{{ __('search') }}">
                    <button type="submit" class="btn btn-dark ml-2">{{ trans('Search') }}</button>
                </form>
            </div>

            <div>
                @can('roles.create')
                    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-success">{{ __('Create') }}</a>
                @endcan
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Permissions #') }}</th>
                        <th>{{ __('User #') }}</th>
                        <th colspan="2">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ count($role->permissions) }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                @can('roles.update')
                                    <a href="{{ route('dashboard.roles.edit', [$role->id]) }}"
                                        class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                                @endcan
                            </td>
                            <td>
                                @can('roles.delet')
                                    <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan
@endsection
