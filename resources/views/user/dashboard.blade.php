@extends('layouts.user.app')
@section('main')
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="container">
            <div class="row gy-4  mt-0">
                <div class="col-lg-6 order-1 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
                    <h1 class="text-center mb-1">Selamat Datang Para Mahasiswa</h1>
                    <p> Anda ingin meminjam ruangan seminar?
                        Silahkan isi form peminjaman terlebih dahulu, terima kasih.
                    </p>
                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">
                    <a class="btn-get-started me-3 me-md-0 mb-2 mb-md-0" style="margin-left: 4px">
                        <i class="bi bi-hand-thumbs-up" style="transform: rotate(0deg); transition: transform 0.3s;"></i>
                    </a>
                </div>
                <style>
                    @media (max-width: 767.98px) {
                        .bi-hand-index-thumb {
                            transform: rotate(-90deg);
                        }
                        .btn-get-started {
                            margin-bottom: 10px !important;
                        }
                    }
                    .btn-get-started i {
                        margin-right: 5px;
                    }
                </style>
            </div>
            <div class="col-lg-6 order-2 order-lg-1 hero-img" data-aos="zoom-out" data-aos-delay="100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div>
                            <!-- Error Message -->
                            @if (isset($error))
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif

                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Form Peminjaman -->
                            <div class="card shadow-sm" style="height: 600px; overflow-y: auto;">
                                <div class="card-body p-4">
                                    <h2 class="card-title text-center mb-4">Form Peminjaman</h2>
                                    <form id="loanForm" action="{{ route('user.peminjaman.store') }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row mb-2">
                                            <div class="col-xl-12 mb-2">
                                                <label class="form-label">
                                                    <span class="text-danger">*</span>
                                                    Nama Peminjam :
                                                </label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ Auth::user()->name ?? old('name') }}" required>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
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
                                                    <small class="text-danger">{{ $message }}</small>
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
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 mb-2">
                                                <label class="form-label">
                                                    <span class="text-danger">*</span>
                                                    Nama Ruangan :
                                                </label>
                                                <select name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror" required>
                                                    <option value="">Pilih Ruangan</option>
                                                    @foreach ($ruangs as $item)
                                                        <option value="{{ $item->id }}" {{ old('ruang_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }} @if(isset($item->kode)) ({{ $item->kode }}) @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ruang_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 mb-2">
                                                <label class="form-label">
                                                    <span class="text-danger">*</span>
                                                    Tanggal Peminjaman :
                                                </label>
                                                <input type="date" name="tanggal_peminjaman" class="form-control @error('tanggal_peminjaman') is-invalid @enderror"
                                                    value="{{ old('tanggal_peminjaman') }}" min="{{ now()->toDateString() }}" required>
                                                @error('tanggal_peminjaman')
                                                    <small class="text-danger">{{ $message }}</small>
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
                                                    <small class="text-danger">{{ $message }}</small>
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
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-save mr-2"></i>
                                                    Ajukan Peminjaman
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Hero Section -->

    {{-- <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

    <div class="container">

        <div class="row gy-4">

        <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-activity icon"></i></div>
            <h4><a href="{{ route('login') }}" class="stretched-link">SOP Laboratorium</a></h4>
            <p>yang terdiri dari SOP praktikum, pemakaian alat, pemakaian ruangan dan lainnya</p>
            <a href="{{ route('login') }}"> Klik Disini </a>
            </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
            <h4><a href="" class="stretched-link">Daftar ALat Laboratorium</a></h4>
            <p>yang terdiri dari berbagai beberapa alat untuk analisis kualiatas air, mikrobiologi dan proksimat lengkap</p>
            </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
            <h4><a href="" class="stretched-link">Jadwal</a></h4>
            <p>yang terdiri dari data jadwal pemakaian ruangan laboratorium</p>
            </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
            <h4><a href="" class="stretched-link">Daftar Peminjaman Alat</a></h4>
            <p>yang terdiri dari data alat laboratorium yang sedang digunakan atau sedang dipinjam</p>
            </div>
        </div><!-- End Service Item -->

        </div>

    </div>

    </section><!-- /Featured Services Section --> --}}
@endsection


</html>

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
