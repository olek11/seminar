@extends('layouts.appadmin')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-building"></i>
        {{ $title }}
    </h1>

<!-- DataTales Example -->
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-sm-center
        justify-content-xl-between">
            <div class="mb-1 mr-2">
                <a href="{{ route('admin.ruang.create') }}" class="btn btn-sm btn-primary">
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
                <table class="table table-bordered" id="dataTable" width="100%"
                cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Kode Ruang</th>
                            <th>Lokasi</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ruang as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">
                                        {{ $item->kode }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">
                                        {{ $item->lokasi }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.ruang.edit',$item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger mt-1" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @include('admin.ruang.modal', ['item' => $item])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


