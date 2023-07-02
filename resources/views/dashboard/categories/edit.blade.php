@extends('layouts.dashboard')
@section('title', 'Edit Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item ">Categories</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">

        @csrf
        {{-- Form Method Spoofing --}}
        {{-- <input type="hidden" name="_method" value="put"> --}}
        @method('put') {{-- نفس الي فوق ولكن هذه طريقة مختصرة ل تيمبليت --}}

        <div class="form-group mb-3">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="parent_id">Category Parent</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @if ($parent->id == $category->parent_id) selected @endif>
                        {{ $parent->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $category->description }}</textarea>
        </div>


        <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>


        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-danger ml-2">Cansel</a>
        </div>


    </form>
@endsection
