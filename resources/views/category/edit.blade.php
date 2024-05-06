@extends('layouts.bootstrap')

@section('title')
Edit Kategori
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
            <h3>Edit {{$category->name_category}}</h3>
        </div>
        <div class="card-body">
            <hr>
            <a href="{{route('category.index')}}" class="btn btn-secondary">Back</a>
            <hr>
            <form method="POST" action="{{ route('category.update', [$category->id]) }}" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}



                <div class="form-group">
                    <label for="name_category">Nama Kategori</label>
                    <input type="text" class="form-control {{$errors->first('name_category') ? 'is-invalid' : ''}}" name="name_category" id="name_category" placeholder="Kategori" value="{{$category->name_category}}">
                    <span class="error invalid-feedback">{{$errors->first('name_category')}}</span>
                </div>


                  <div class="form-group">
                    <label for="image_category">Photo Kategori</label>
                    <input type="file" class="form-control {{$errors->first('image_category') ? 'is-invalid' : ''}}"
                    name="image_category" id="image_category">
                    <span class="error invalid-feedback">{{$errors->first('image_category')}}</span>
                  </div>



                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Update Kategori Sekarang</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
@endsection
