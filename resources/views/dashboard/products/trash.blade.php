@extends('layouts.dashboard')
@section('title', 'Products Trash')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item light">Trash</li>
@endsection

@section('content')

    <div class="table-toobar mb-3">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">Create</a>
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-primary">Back</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Deleted At</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ Storage::disk('uploads')->url($product->image) }}" height="60">
                             @else
                             <img src="{{ asset('images/defluat.jpg') }}" height="60">
                            @endif
                        </td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->deleted_at }}</td>
                        <td>
                            <form action="{{ route('dashboard.products.restore',$product->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.products.destroy',$product->id) }}" method="post">
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
