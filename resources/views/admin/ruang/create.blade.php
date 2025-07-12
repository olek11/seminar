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
                <a href="{{ route('admin.ruang') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ruang.store')}}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col-xl-12 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Nama Ruangan :
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Kode Ruangan :
                        </label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                        value="{{ old('kode') }}">
                        @error('kode')
                            <small class="text-danger">
                               {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label class="from-label">
                            <span class="text-danger">*</span>
                            Lokasi :
                        </label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                        value="{{ old('lokasi') }}">
                        @error('lokasi')
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

