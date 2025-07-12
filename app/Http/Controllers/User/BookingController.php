<?php

namespace App\Http\Controllers\User;

use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Menampilkan dashboard user dengan form peminjaman
     * @return \Illuminate\View\View
     */
    public function showDashboard()
    {
        $ruang = Ruang::where('status', 'tersedia')->get();
        return view('dashboard', ['ruang' => $ruang]);
    }

    /**
     * Menyimpan data peminjaman baru dari user ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['error' => 'Anda harus login untuk mengajukan peminjaman.']);
        }

        // Validasi input
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:' . now()->toDateString(),
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'name' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
        ]);

        // Ambil data user yang login
        $user = Auth::user();
        $data = [
            'ruang_id' => $request->ruang_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'menunggu',
            'name' => $user->name ?? $request->name, // Gunakan 'name' standar Laravel
            'NIM' => $user->NIM ?? $request->NIM,
            'jurusan' => $user->jurusan ?? $request->jurusan,
            'user_id' => Auth::id(),
        ];

        // Cek apakah ada konflik jadwal
        $conflict = Peminjaman::where('ruang_id', $request->ruang_id)
            ->where('tanggal_peminjaman', $request->tanggal_peminjaman)
            ->where('status', 'disetujui')
            ->where(function ($query) use ($request) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
            })->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Ruangan sudah dipinjam pada waktu tersebut.']);
        }

        // Simpan data peminjaman
        try {
            Peminjaman::create($data);
        } catch (\Exception $e) {
            Log::error('Error menyimpan peminjaman: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan peminjaman. Periksa log untuk detail.']);
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan!');
    }
}
