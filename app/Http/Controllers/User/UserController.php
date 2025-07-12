<?php

namespace App\Http\Controllers\User;

use App\Models\Peminjaman;
use App\Models\Ruang;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Constructor untuk mengatur middleware autentikasi
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya pengguna terautentikasi yang bisa akses
    }

    // Bagian Dashboard
    public function index()
    {
        try {
            $ruangs = Ruang::all(); // Ambil semua data ruang
            $peminjamans = Peminjaman::with('ruang')->where('status', 'menunggu')->get(); // Ambil peminjaman menunggu
            return view('user.dashboard', [
                'ruangs' => $ruangs,
                'peminjamans' => $peminjamans,
            ]);
        } catch (Exception $e) {
            return view('user.dashboard', [
                'ruangs' => collect(),
                'peminjamans' => collect(),
                'error' => 'Error memuat dashboard: ' . $e->getMessage()
            ]);
        }
    }

    // Bagian Peminjaman
    public function store(Request $request)
    {

        $request->validate([
            'ruang_id' => 'required|exists:ruang,id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:' . now()->toDateString(),
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'name' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama Peminjam wajib diisi.',
            'NIM.required' => 'NIM wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'ruang_id.required' => 'Nama Ruangan wajib dipilih.',
            'ruang_id.exists' => 'Ruangan yang dipilih tidak valid.',
            'tanggal_peminjaman.required' => 'Tanggal Peminjaman wajib diisi.',
            'tanggal_peminjaman.date' => 'Tanggal Peminjaman harus dalam format yang valid.',
            'tanggal_peminjaman.after_or_equal' => 'Tanggal Peminjaman harus hari ini atau ke depan.',
            'waktu_mulai.required' => 'Waktu Mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu Selesai wajib diisi.',
            'waktu_selesai.after' => 'Waktu Selesai harus setelah Waktu Mulai.',
            'name.max' => 'Nama Peminjam tidak boleh lebih dari 255 karakter.',
            'NIM.max' => 'NIM tidak boleh lebih dari 20 karakter.',
            'jurusan.max' => 'Jurusan tidak boleh lebih dari 255 karakter.',
        ]);

        // Simpan data peminjaman
        Peminjaman::create([
            'ruang_id' => $request->input('ruang_id'),
            'tanggal_peminjaman' => $request->input('tanggal_peminjaman'),
            'waktu_mulai' => $request->input('waktu_mulai'),
            'waktu_selesai' => $request->input('waktu_selesai'),
            'status' => 'menunggu',
            'name' => $request->input('name'),
            'NIM' => $request->input('NIM'),
            'jurusan' => $request->input('jurusan'),
        ]);
        return redirect()->route('dashboard')->with([
            'success' => 'Peminjaman berhasil diajukan!',
            'showModal' => true
        ]);
    }

    // Menampilkan halaman daftar peminjaman pengguna
    public function peminjaman()
    {
        \Carbon\Carbon::setLocale('id'); // Set locale untuk format tanggal bahasa Indonesia
        $peminjamans = Peminjaman::where('user_id', Auth::id())->paginate(10); // Ambil peminjaman milik pengguna
        return view('user.dashboard', [
            'title' => 'Daftar Peminjaman',
            'peminjamans' => $peminjamans,
            'menuUserPeminjaman' => 'active',
        ]);
    }
}
