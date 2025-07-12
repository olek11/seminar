{{-- <!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="card shadow-sm">
            <div class="modal-content">
                @if (session('showErrorModal'))
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Terjadi Kesalahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Mohon periksa kembali data Anda:</p>
                        <ul class="list-group list-group-flush">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                @elseif (session('showModal'))
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Peminjaman Telah Diajukan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ session('success') }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nama Peminjam:</strong> <span id="modalName">{{ session('name') }}</span></li>
                            <li class="list-group-item"><strong>Nomor Identitas Mahasiswa (NIM):</strong> <span id="modalNIM">{{ session('NIM') }}</span></li>
                            <li class="list-group-item"><strong>Program Studi:</strong> <span id="modalJurusan">{{ session('jurusan') }}</span></li>
                            <li class="list-group-item"><strong>Ruangan yang Dipilih:</strong> <span id="modalRuang">{{ session('ruang_name') }}</span></li>
                            <li class="list-group-item"><strong>Tanggal Peminjaman:</strong> <span id="modalTanggal">{{ session('tanggal_peminjaman') }}</span></li>
                            <li class="list-group-item"><strong>Jam Mulai:</strong> <span id="modalWaktuMulai">{{ session('waktu_mulai') }}</span></li>
                            <li class="list-group-item"><strong>Jam Selesai:</strong> <span id="modalWaktuSelesai">{{ session('waktu_selesai') }}</span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Oke, Mengerti</button>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}
