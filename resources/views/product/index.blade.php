@extends('layouts.bootstrap')
@section('title')
Data Product
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
            <h3>Data Product</h3>
        </div>
        <div class="card-body table-responsive">
            <br>
            <form method="GET" action="{{route('product.index')}}">
                <div class="row">
                    <div class="col-2">
                        <b>Search Nama Product</b>
                    </div>

                    <div class="col-3">
                        <input type="text" name="keyword" id="keyword" class="form-control" value="{{Request::get('keyword')}}">
                    </div>

                    <div class="col-4">
                        <button class="btn btn-default" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered">
            <br>
            <hr>
            <a href="{{route('product.create')}}" class="btn btn-success">+ Tambahkan Product</a>
            <br>
            <hr>
		<thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Size</th>
                    <th>Action</th>
                </tr>
		</thead>
                <tbody>
                    @foreach ($product as $row )
                    <tr>
                        <td>{{ $loop->iteration + ($product->perPage() * ($product->currentPage() - 1) ) }}</td>
                        <td>{{$row->name_product}}</td>
                        <td>{{$row->price_product}}</td>
                        <td>{{$row->category->name_category}}</td>
                        <td>
                            @foreach ($row->sizes as $size)
                                <div>
                                    <strong>{{ $size->name_size }}</strong>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route ('product.edit', [$row->id])}}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('product.destroy', [$row->id]) }}" class="d-inline" method="POST" onsubmit="return confirm('Delete This Item ?')">
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
            {{$product->links()}}
        </div>
      </div>
    </div>
  </div>
@endsection
