@extends('layouts.dashboard')
@section('title', $title)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item light">Categories</li>
@endsection

@section('content')

    <div class="table-toobar mb-3">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success">Create</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Created At</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td></td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a href="{{ route('dashboard.categories.edit',$category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.categories.destroy',$category->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
