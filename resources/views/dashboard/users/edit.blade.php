@extends('layouts.dashboard')
@section('title', __('Edit Users'))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "> {{ __('Users') }}</li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post">
        @method('put')
        @include('dashboard.users._form', [
            'button' => 'Update',
            'button2' => 'Cansel Update',
        ])
    </form>
@endsection