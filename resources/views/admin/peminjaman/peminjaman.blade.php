@php
    use Carbon\Carbon;
    Carbon::setLocale('id'); // Mengatur locale global
@endphp

@extends('layouts.appadmin')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-building"></i>
        {{ $title ?? 'Daftar Peminjaman' }}
    </h1>

    <!-- DataTales Example -->
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-sm-center justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data
                </a>
            </div>
            <div>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel mr-2"></i>
                    Excel
                </a>
                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf mr-2"></i>
                    PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                            <th>Pemesan</th>
                            <th>NIM</th>
                            <th>Jurusan</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $item)
                            <tr>
                                <td class="text-center">{{ $peminjaman->firstItem() + $index }}</td>
                                <td>{{ $item->ruang->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ Carbon::parse($item->tanggal_peminjaman)->format('l, d F Y') }}</td>
                                <td class="text-center">{{ Carbon::parse($item->waktu_mulai)->format('H:i') }} WIB</td>
                                <td class="text-center">{{ Carbon::parse($item->waktu_selesai)->format('H:i') }} WIB</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->status == 'disetujui' ? 'badge-success' : ($item->status == 'selesai' ? 'badge-secondary' : ($item->status == 'menunggu' ? 'badge-warning' : 'badge-danger')) }}">
                                        {{ $item->status ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $item->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->NIM ?? 'N/A' }}</td>
                                <td class="text-center">{{ $item->jurusan ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($item->status !== 'disetujui')
                                        <form method="POST" action="{{ route('admin.peminjaman.setStatus', ['id' => $item->id, 'status' => 'disetujui']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success mt-1 mb-2" onclick="return confirm('Setujui peminjaman ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($item->status !== 'ditolak')
                                        <form method="POST" action="{{ route('admin.peminjaman.setStatus', ['id' => $item->id, 'status' => 'ditolak']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger mt-2 mb-2" onclick="return confirm('Tolak peminjaman ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.peminjaman.edit', $item->id) }}" class="btn btn-sm btn-warning mt-1 mb-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger mt-1 mb-2" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @include('admin.peminjaman.modal', ['peminjaman' => $item])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
