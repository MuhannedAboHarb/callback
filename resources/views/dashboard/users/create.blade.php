@extends('layouts.dashboard')
@section('title', 'Create Users')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item ">{{ __('Users') }}</li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    {{-- this is object --}}
    @if (session()->has('success'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            {{ session('success') }}
        </div>
    @endif


    <form action="{{ route('dashboard.users.store') }}" method="post">
        @include('dashboard.users._form', [
            'button' => 'Create',
            'button2' => 'Cansel Create',
        ])
    </form>
@endsection
