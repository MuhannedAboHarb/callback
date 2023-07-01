@extends('layouts.dashboard')
@section('title',$title)
@section('breadcrumb')
  @parent
  <li class="breadcrumb-item light">Categories</li>
@endsection

@section('content')

  <div class="table-toobar mb-3">
    <a href="{{route('dashboard.categories.create')}}" class="btn btn-success">Create</a>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($entries as $entry)
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
