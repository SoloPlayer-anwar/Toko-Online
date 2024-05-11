@extends('layouts.bootstrap')

@section('title')
Create Product
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
            <h3>Create Product</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name_product">Name Product</label>
                    <input type="text" class="form-control {{$errors->first('name_product') ? 'is-invalid' : ''}}" name="name_product" id="name_product" placeholder="Enter Nama Product" value="{{ old('name_product') }}">
                    <span class="error invalid-feedback">{{$errors->first('name_product')}}</span>
                  </div>


                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control {{$errors->first('description') ? 'is-invalid' : ''}}" name="description" id="description" placeholder="Enter Description Product">{{ old('description') }}</textarea>
                    <span class="error invalid-feedback">{{$errors->first('description')}}</span>
                  </div>


                  <div class="form-group">
                    <label for="price_product">Price</label>
                    <input type="number" class="form-control {{$errors->first('price_product') ? 'is-invalid' : ''}}"
                    name="price_product" id="price_product">
                    <span class="error invalid-feedback">{{$errors->first('price_product')}}</span>
                  </div>

                  <div class="form-group">
                    <label for="price_strike">Price Coret</label>
                    <input type="number" class="form-control {{$errors->first('price_strike') ? 'is-invalid' : ''}}"
                    name="price_strike" id="price_strike">
                    <span class="error invalid-feedback">{{$errors->first('price_strike')}}</span>
                  </div>


                  <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">>-- Pilih Kategori --<</option>
                        @foreach ($category as $categories )
                        <option value="{{$categories->id}}">{{$categories->name_category}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="variants">Varian Produk</label>
                    <div id="variants-container">
                        <!-- Varian akan ditambahkan di sini secara dinamis -->
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <button type="button" class="btn btn-success" onclick="addVariant()">
                            <i class="fas fa-plus"></i> Tambah Varian
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sizes">Size Product</label>
                    <div id="sizes-container">
                        <!-- Varian akan ditambahkan di sini secara dinamis -->
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <button type="button" class="btn btn-success" onclick="addSize()">
                            <i class="fas fa-plus"></i> Tambah Size
                        </button>
                    </div>
                </div>

                <script>
                    let variantCount = 0;

                    function addVariant() {
                        variantCount++;

                        const variantContainer = document.getElementById('variants-container');
                        const variantRow = document.createElement('div');
                        variantRow.className = 'row mb-2';

                        const nameCol = document.createElement('div');
                        nameCol.className = 'col-8';

                        const nameInput = document.createElement('input');
                        nameInput.type = 'text';
                        nameInput.name = `variants[${variantCount - 1}][name]`;
                        nameInput.placeholder = 'Nama Varian';
                        nameInput.className = 'form-control';
                        nameCol.appendChild(nameInput);

                        const imageCol = document.createElement('div');
                        imageCol.className = 'col-8';

                        const imageInput = document.createElement('input');
                        imageInput.type = 'file';
                        imageInput.name = `variants[${variantCount - 1}][image]`;
                        imageInput.className = 'form-control';
                        imageCol.appendChild(imageInput);

                        const removeCol = document.createElement('div');
                        removeCol.className = 'col-4';

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.textContent = 'Hapus';
                        removeButton.className = 'btn btn-small btn-danger btn-block';
                        removeButton.onclick = function() {
                            variantContainer.removeChild(variantRow);
                        };
                        removeCol.appendChild(removeButton);

                        variantRow.appendChild(nameCol);
                        variantRow.appendChild(imageCol);
                        variantRow.appendChild(removeCol);

                        variantContainer.appendChild(variantRow);
                    }


                    let sizeCount = 0;

                    function addSize() {
                        sizeCount++;

                        const sizeContainer = document.getElementById('sizes-container');
                        const sizesRow = document.createElement('div');
                        sizesRow.className = 'row mb-2';

                        const nameCol = document.createElement('div');
                        nameCol.className = 'col-8';

                        const nameInput = document.createElement('input');
                        nameInput.type = 'text';
                        nameInput.name = `sizes[${sizeCount - 1}][name]`;
                        nameInput.placeholder = 'Ukuran';
                        nameInput.className = 'form-control';
                        nameCol.appendChild(nameInput);

                        const removeCol = document.createElement('div');
                        removeCol.className = 'col-4';

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.textContent = 'Hapus';
                        removeButton.className = 'btn btn-small btn-danger btn-block';
                        removeButton.onclick = function() {
                            sizeContainer.removeChild(sizesRow);
                        };
                        removeCol.appendChild(removeButton);

                        sizesRow.appendChild(nameCol);
                        sizesRow.appendChild(removeCol);

                        sizeContainer.appendChild(sizesRow);
                    }

                </script>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
@endsection
