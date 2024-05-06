@extends('layouts.bootstrap')
@section('title')
Kategori
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
            <h3>Data Kategori</h3>
        </div>
        <div class="card-body table-responsive">
            <br>

            <form method="GET" action="{{route('category.index')}}">
                <div class="row">
                    <div class="col-2">
                        <b>Search Nama Kategori</b>
                    </div>
                    <div class="col-3 mb-3">
                        <input type="text" name="keyword" id="keyword" class="form-control" value="{{Request::get('keyword')}}">
                    </div>
                    <div class="col-4">
                        <button class="btn btn-default" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <a href="{{route('category.create')}}" class="btn btn-success">+ Tambah Kategori</a>
            <hr>
            <table class="table table-bordered">
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Photo Kategori</th>
                        <th>Action</th>
                    </tr>
            </thead>
                <tbody>
                    @foreach ($category as $row )
                    <tr>
                        <td>{{ $loop->iteration + ($category->perPage() * ($category->currentPage() - 1) ) }}</td>
                        <td>{{$row->name_category}}</td>
                        <td><img src="{{$row->image_category}}" alt="photo" width="40px;" height="40px;"></td>
                        <td>
                            <a href="{{ route ('category.edit', [$row->id])}}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('category.destroy', [$row->id]) }}" class="d-inline" method="POST" onsubmit="return confirm('Delete This Item ?')">
                                @csrf
                                {{method_field('DELETE')}}
                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{$category->links()}}
        </div>
      </div>
    </div>
  </div>
@endsection
