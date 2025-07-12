@extends('layouts.appadmin')

@section('content')
    <h2 class="h3 mb-4 text-gray-800">
        <i class="fas fa-tachometer-alt mr-2"></i>
            {{ $title }}
    </h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistik Simpel -->
    <div class="row -center">
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-primary shadow h-200 py-1">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Pengguna</h6>
                    <p class="card-text text-gray-800">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-warning border-bottom-gray shadow h-200 py-1">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-warning">Peminjaman Menunggu</h6>
                    <p class="card-text text-gray-800">{{ $peminjamans->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-left-success shadow h-200 py-1">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-success">Jumlah Ruang</h6>
                    <p class="card-text text-gray-800">{{ $ruangs->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Peminjaman Menunggu -->
    <div class="card shadow mt-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Peminjaman Menunggu</h6>
        </div>
        <div class="card-body">
            @if ($peminjamans->isEmpty())
                <p class="text-center">Tidak ada peminjaman menunggu.</p>
            @else
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $index => $peminjaman)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $peminjaman->name ?? 'Tidak Ditemukan' }}</td>
                                <td>{{ $peminjaman->ruang->name ?? 'Tidak Ditemukan' }}</td>
                                <td>{{ $peminjaman->tanggal_peminjaman ? \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d F Y') : 'Tidak Ditemukan' }}</td>
                                <td>{{ $peminjaman->waktu_mulai ? date('H:i', strtotime($peminjaman->waktu_mulai)) . ' - ' . date('H:i', strtotime($peminjaman->waktu_selesai)) : 'Tidak Ditemukan' }}</td>
                                <td>
                                    <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Kalender untuk Ruang yang Sedang Digunakan -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ruang yang Sedang Digunakan</h6>
        </div>
        <div class="card-body">
            <div id="calendar" style="max-width: 100%; width: 800px; margin: 0 auto;"></div> <!-- Lebar maksimum 800px -->
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: [
                    {
                        title: 'Ruang Seminar 02 - user2',
                        start: '2025-06-25T16:26:00',
                        end: '2025-06-25T16:30:00',
                        color: '#007bff'
                    },
                    {
                        title: 'Ruang Seminar 02 - admin',
                        start: '2025-06-27T10:25:00',
                        end: '2025-06-27T15:22:00',
                        color: '#007bff'
                    }
                ],
                eventClick: function(info) {
                    alert('Ruang: ' + info.event.title + '\nWaktu: ' + info.event.start.toLocaleString() + ' - ' + info.event.end.toLocaleString());
                }
            });
            calendar.render();
        });
    </script>
@endsection

{{-- <!-- Tambahkan FullCalendar CSS dan JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($calendarEvents);
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            eventContent: function(arg) {
                return { html: arg.event.title + '<br><small>' + arg.event.extendedProps.name + ' (NIM: ' + arg.event.extendedProps.NIM + ')</small>' };
            }
        });
        calendar.render();
    });
</script>
@endsection --}}
