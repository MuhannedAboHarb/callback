@extends('layouts.dashboard')

@section('title' , 'Profile Update')

@section('content')
    

    <x-flash-message />

    <form action="{{ route('profile.update') }}" method="post">
        @csrf
        @method('patch')

        <div class="form-group">
            <x-form.input name="name" :value=" $user->name " lable="Name" />    
        </div>

        <div class="form-group">
            <x-form.input name="email" :value=" $user->email " lable="Email Address" />
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info"> Update </button>
        </div>   

    </form>



@endsection