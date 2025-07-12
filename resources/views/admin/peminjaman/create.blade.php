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
                <a href="{{ route('admin.peminjaman') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col-xl-12 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Nama Ruangan :
                        </label>
                        <select name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($ruang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->kode }})</option>
                            @endforeach
                        </select>
                        @error('ruang_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Tanggal Peminjaman :
                        </label>
                        <input type="date" name="tanggal_peminjaman" class="form-control @error('tanggal_peminjaman') is-invalid @enderror"
                               value="{{ old('tanggal_peminjaman') }}" required>
                        @error('tanggal_peminjaman')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Waktu Mulai :
                        </label>
                        <input type="time" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror"
                               value="{{ old('waktu_mulai') }}" required>
                        @error('waktu_mulai')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Waktu Selesai :
                        </label>
                        <input type="time" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror"
                               value="{{ old('waktu_selesai') }}" required>
                        @error('waktu_selesai')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Nama Pemesan :
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            NIM :
                        </label>
                        <input type="text" name="NIM" class="form-control @error('NIM') is-invalid @enderror"
                               value="{{ old('NIM') }}" required>
                        @error('NIM')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-2">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Jurusan :
                        </label>
                        <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                               value="{{ old('jurusan') }}" required>
                        @error('jurusan')
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
