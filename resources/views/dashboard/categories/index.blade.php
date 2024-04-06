@extends('layouts.dashboard')
@section('title', __($title))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item light">{{ __('Categories') }}</li>
@endsection

@section('content')

    <x-flash-message name="success" />

    <div class="table-toobar row mb-3 d-flex justify-content-between">
        <div class="">
            <form action="{{ route('dashboard.categories.index') }}" class="d-flex" method="get">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="{{ __('search') }}">
                <button type="submit" class="btn btn-dark ml-2">{{ trans('Search') }}</button>
            </form>
        </div>

        <div>
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success">{{ __('Create') }}</a>
            <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-primary">{{ __('Trash') }}</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>@lang('ID')</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Parent') }}</th>
                    <th>{{ __('description') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <img src="{{ $category->image_url }}" height="60">
                        </td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a href="{{ route('dashboard.categories.edit', [$category->id]) }}"
                                class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
