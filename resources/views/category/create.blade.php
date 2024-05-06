@extends('layouts.bootstrap')

@section('title')
Create Kategori
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-warning">
        <div class="card-header">
            <h3>Create Kategori</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="name_category">Nama Kategori</label>
                        <input type="text" class="form-control {{$errors->first('name_category') ? 'is-invalid' : ''}}" name="name_category" id="name_category" placeholder="Tulis nama Kategori" value="{{ old('name_category') }}">
                        <span class="error invalid-feedback">{{$errors->first('name_category')}}</span>
                    </div>


                    <div class="form-group">
                        <label for="image_category">Photo Kategori</label>
                        <input type="file" class="form-control-file {{$errors->first('image_category') ? 'is-invalid' : ''}}" name="image_category" id="image_category">
                        <span class="error invalid-feedback">{{$errors->first('image_category')}}</span>
                    </div>


                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan Data Sekarang</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
@endsection
