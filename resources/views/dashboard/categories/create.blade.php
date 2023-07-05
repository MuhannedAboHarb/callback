@extends('layouts.dashboard')
@section('title', 'Create Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item ">Categories</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    {{-- this is object --}}
    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif --}}



    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @include('dashboard.categories._form', [
            'button' => 'Create',
            'button2' => 'Cansel Create'
        ])
    </form>
@endsection
