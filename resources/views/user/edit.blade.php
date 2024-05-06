@extends('layouts.bootstrap')

@section('title')
Edit User
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
            <a href="{{route('user.index')}}">Back</a>
            <h3>Edit {{$user->name}}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.update', [$user->id]) }}" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Username</label>
                    <input type="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" name="name" id="name" placeholder="Enter name" value="{{ $user->name }}">
                    <span class="error invalid-feedback">{{$errors->first('name')}}</span>
                  </div>


                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" name="email" id="email" placeholder="Enter Email" value="{{ $user->email }}">
                    <span class="error invalid-feedback">{{$errors->first('email')}}</span>
                  </div>


                  <div class="form-group">
                    <label for="password">Password Lama</label>
                    <input type="password" class="form-control" disabled id="password" placeholder="Enter password" value="{{ $user->password }}">
                  </div>

                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
                  </div>


                  <div class="form-group">
                    <label for="phone">No Handphone</label>
                    <input type="phone" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" name="phone" id="phone" placeholder="Enter phone" value="{{ $user->phone }}">
                    <span class="error invalid-feedback">{{$errors->first('phone')}}</span>
                  </div>



                  <div class="form-group">
                    <label for="avatar">Avatar Baru</label>
                    <input type="file" class="form-control {{$errors->first('avatar') ? 'is-invalid' : ''}}"
                    name="avatar" id="avatar">
                    <span class="error invalid-feedback">{{$errors->first('avatar')}}</span>
                  </div>

                  <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control {{$errors->first('role') ?  'is-invalid' : ''}}">
                        <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                        <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                        <option value="kurir" @if ($user->role == 'kurir') selected @endif>Kurir</option>
                    </select>
                    <span class="error invalid-feedback">{{$errors->first('role')}}</span>
                  </div>


                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Update User</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
@endsection
