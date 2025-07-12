<div class="modal fade" id="deleteModal{{ $peminjaman->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $peminjaman->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel{{ $peminjaman->id }}">Hapus Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="row">
                    <div class="col-6">Nama Ruangan</div>
                    <div class="col-6">: {{ $peminjaman->ruang->name ?? 'Tidak tersedia' }} ({{ $peminjaman->ruang->kode ?? '' }})</div>
                    <div class="col-6">Tanggal Peminjaman</div>
                    <div class="col-6">: {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d F Y') ?? 'N/A' }}</div>
                    <div class="col-6">Waktu Mulai</div>
                    <div class="col-6">: {{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') ?? 'N/A' }} WIB</div>
                    <div class="col-6">Waktu Selesai</div>
                    <div class="col-6">: {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') ?? 'N/A' }} WIB</div>
                    <div class="col-6">Nama Pemesan</div>
                    <div class="col-6">: {{ $peminjaman->name ?? 'N/A' }}</div>
                    <div class="col-6">NIM</div>
                    <div class="col-6">: {{ $peminjaman->NIM ?? 'N/A' }}</div>
                    <div class="col-6">Jurusan</div>
                    <div class="col-6">: {{ $peminjaman->jurusan ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
