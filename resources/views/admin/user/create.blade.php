@extends('layouts.appadmin')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus mr-2"></i>
        {{ $title }}
    </h1>
 <!-- DataTales Example -->
    <div class="card">
        <div class="card-header d-flex flex-wrap bg-primary">
            <div class="mb-1 mr-2">
                <a href="{{ route('admin.user') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.store')}}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col-xl-6 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Nama :
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Email :
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            usertype :
                        </label>
                        <select name="usertype" class="form-control @error('usertype') is-invalid @enderror">
                            <option value="" selected disabled>--Pilih Tipe User--</option>
                            <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('usertype') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('usertype')
                            <small class="text-danger">
                            {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Password :
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Password Konfirmasi:
                        </label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save mr-2"></i>
                                Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

