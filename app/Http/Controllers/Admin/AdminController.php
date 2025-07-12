<?php

namespace App\Http\Controllers\Admin;

use \Exception;
use App\Models\Peminjaman;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk mengelola fungsi admin berdasarkan halaman (dashboard, pengguna, ruang, peminjaman)
 */
class AdminController extends Controller
{
    /**
     * Constructor untuk mengatur middleware autentikasi
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya pengguna terautentikasi yang bisa akses
    }

    // =========================================================================
    // Bagian Dashboard
    // =========================================================================

    /**
     * Menampilkan dashboard utama dengan data lengkap (ruang, peminjaman, pengguna)
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        try {
            $ruangs = Ruang::all(); // Ambil semua data ruang
            $peminjamans = Peminjaman::with('ruang')->where('status', 'menunggu')->get(); // Ambil peminjaman menunggu
            $users = User::all(); // Ambil semua data pengguna
            return view('admin.dashboard', [
                'ruangs' => $ruangs,
                'peminjamans' => $peminjamans,
                'users' => $users,
                'title' => 'Dashboard Admin', // Tambahkan title di sini
                'menuAdminDashboard' => 'active',
            ]);
        } catch (Exception $e) {
            return view('admin.dashboard', [
                'ruangs' => collect(),
                'peminjamans' => collect(),
                'users' => collect(),
                'title' => 'Dashboard Admin',
                'error' => 'Error memuat dashboard: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Menyetujui peminjaman dengan cek bentrok jadwal
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approvePeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $bentrok = Peminjaman::where('ruang_id', $peminjaman->ruang_id)
            ->where('tanggal_peminjaman', $peminjaman->tanggal_peminjaman)
            ->where('status', 'disetujui')
            ->where('id', '!=', $peminjaman->id)
            ->where(function ($query) use ($peminjaman) {
                $query->whereBetween('waktu_mulai', [$peminjaman->waktu_mulai, $peminjaman->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$peminjaman->waktu_mulai, $peminjaman->waktu_selesai])
                    ->orWhere(function ($q) use ($peminjaman) {
                        $q->where('waktu_mulai', '<=', $peminjaman->waktu_mulai)
                            ->where('waktu_selesai', '>=', $peminjaman->waktu_selesai);
                    });
            })
            ->exists();

        if ($bentrok) {
            return redirect()->route('admin.dashboard')->with('error', 'Jadwal bentrok dengan peminjaman lain!');
        }

        $peminjaman->update(['status' => 'disetujui']);
        return redirect()->route('admin.dashboard')->with('success', 'Peminjaman disetujui!');
    }

    /**
     * Menolak peminjaman
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);
        return redirect()->route('admin.dashboard')->with('success', 'Peminjaman ditolak!');
    }

    // =========================================================================
    // Bagian Pengguna
    // =========================================================================

    /**
     * Menampilkan halaman kelola pengguna
     * @return \Illuminate\View\View
     */
    public function user()
    {
        $users = User::all(); // Ambil semua data pengguna
        return view('admin.user.user', [
            'title' => 'Kelola Pengguna',
            'menuAdminUser' => 'active',
            'users' => $users, // Kirim data pengguna ke view
        ]);
    }

    /**
     * Menampilkan form untuk menambah pengguna baru
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user.create', [
            'title' => 'Tambah Data User',
            'menuAdminUser' => 'active',
        ]); // Hanya kirim judul dan menu, data pengguna nggak perlu di form create
    }

    /**
     * Menyimpan data pengguna baru ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'required|in:admin,user',
        ]);

        // Simpan data pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
        ]);

        // Redirect ke halaman kelola pengguna dengan pesan sukses
        return redirect()->route('admin.user')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Ambil data pengguna berdasarkan ID
        return view('admin.user.edit', [
            'user' => $user,
            'title' => 'Edit Data User',
            'menuAdminUser' => 'active',
        ]);
    }

    /**
     * Memperbarui data pengguna di database
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'usertype' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id); // Ambil data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->usertype = $request->usertype;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Update password kalau diisi
        }
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus data pengguna dari database
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Ambil data pengguna
        $user->delete(); // Hapus data

        return redirect()->route('admin.user')->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Menampilkan form untuk mengedit data pengguna
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id); // Ambil data pengguna
        return view('admin.user.edit', [
            'user' => $user,
            'title' => 'Edit Data User',
            'menuAdminUser' => 'active',
        ]);
    }

    /**
     * Menghapus data pengguna dari database
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id); // Ambil data pengguna
        $user->delete(); // Hapus data

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna dihapus!');
    }

    // =========================================================================
    // Bagian Ruang
    // =========================================================================

    /**
     * Menampilkan halaman daftar ruangan
     * @return \Illuminate\View\View
     */
    public function ruang()
    {
        return view('admin.ruang.ruang', [
            'title' => 'Daftar Ruangan',
            'menuAdminRuang' => 'active',
            'ruang' => Ruang::all(), // Ambil semua data ruang
        ]);
    }

    /**
     * Menampilkan form untuk menambah ruangan baru
     * @return \Illuminate\View\View
     */
    public function createruang()
    {
        return view('admin.ruang.create', [
            'title' => 'Tambah Data Ruangan',
            'menuAdminRuang' => 'active',
        ]);
    }

    /**
     * Menyimpan data ruangan baru ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeruang(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ruang,name',
            'kode' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        Ruang::create($validated);

        return redirect()->route('admin.ruang')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data ruangan
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editruang($id)
    {
        $ruang = Ruang::findOrFail($id); // Ambil data ruang berdasarkan ID
        return view('admin.ruang.edit', [
            'title' => 'Edit Ruangan',
            'ruang' => $ruang,
        ]);
    }

    /**
     * Memperbarui data ruangan di database
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateruang(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ruang,name,' . $id,
            'kode' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        $ruang = Ruang::findOrFail($id); // Ambil data ruang
        $ruang->update($validated);

        return redirect()->route('admin.ruang')->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Menghapus data ruangan dari database
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyruang($id)
    {
        $ruang = Ruang::findOrFail($id); // Ambil data ruang
        $ruang->delete(); // Hapus data

        return redirect()->route('admin.ruang')->with('success', 'Ruangan berhasil dihapus!');
    }

    // =========================================================================
    // Bagian Peminjaman
    // =========================================================================

    /**
     * Menampilkan halaman daftar peminjaman
     * @return \Illuminate\View\View
     */
    public function peminjaman()
    {
        \Carbon\Carbon::setLocale('id'); // Set locale untuk format tanggal bahasa Indonesia
        $peminjaman = Peminjaman::with('ruang')->paginate(10); // Ambil data peminjaman dengan relasi ruang
        return view('admin.peminjaman.peminjaman', [
            'title' => 'Daftar Peminjaman',
            'peminjaman' => $peminjaman,
            'menuAdminPeminjaman' => 'active',
        ]);
    }

    /**
     * Menampilkan form untuk menambah peminjaman baru
     * @return \Illuminate\View\View
     */
    public function createpeminjaman()
    {
        $ruang = Ruang::where('status', 'tersedia')->get(); // Ambil ruang yang tersedia
        return view('admin.peminjaman.create', compact('ruang'))->with('title', 'Tambah Peminjaman Ruangan');
    }

    /**
     * Menyimpan data peminjaman baru ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storepeminjaman(Request $request)
    {
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:' . now()->toDateString(),
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'name' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
        ]);

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
        Peminjaman::create([
            'ruang_id' => $request->ruang_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'menunggu',
            'name' => $request->name,
            'NIM' => $request->NIM,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil diajukan!');
    }

    /**
     * Menampilkan form untuk mengedit data peminjaman
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editpeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Ambil data peminjaman
        // Konversi waktu ke format HH:MM
        $peminjaman->waktu_mulai = $peminjaman->waktu_mulai ? date('H:i', strtotime((string) $peminjaman->waktu_mulai)) : '';
        $peminjaman->waktu_selesai = $peminjaman->waktu_selesai ? date('H:i', strtotime((string) $peminjaman->waktu_selesai)) : '';

        $ruang = Ruang::where('status', 'tersedia')
            ->orWhere('id', $peminjaman->ruang_id)
            ->get(); // Ambil ruang tersedia atau ruang saat ini
        return view('admin.peminjaman.edit', [
            'title' => 'Edit Peminjaman',
            'peminjaman' => $peminjaman,
            'ruang' => $ruang,
        ]);
    }

    /**
     * Memperbarui data peminjaman di database
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatepeminjaman(Request $request, $id)
    {
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id',
            'tanggal_peminjaman' => 'required|date|after_or_equal:' . now()->toDateString(),
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'name' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'jurusan' => 'required|string|max:255',
        ]);

        // Cek apakah ada konflik jadwal
        $conflict = Peminjaman::where('ruang_id', $request->ruang_id)
            ->where('tanggal_peminjaman', $request->tanggal_peminjaman)
            ->where('status', 'disetujui')
            ->where('id', '!=', $id) // Hindari konflik dengan record sendiri
            ->where(function ($query) use ($request) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
            })->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Ruangan sudah dipinjam pada waktu tersebut.']);
        }

        // Update data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'ruang_id' => $request->ruang_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'name' => $request->name,
            'NIM' => $request->NIM,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    /**
     * Menghapus data peminjaman dari database
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroypeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Ambil data peminjaman
        $peminjaman->delete(); // Hapus data

        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }

    /**
     * Mengatur status peminjaman (misal menunggu, disetujui, ditolak)
     * @param int $id
     * @param string $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStatus($id, $status)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Ambil data peminjaman
        $peminjaman->status = $status; // Ubah status
        $peminjaman->save();

        return redirect()->route('admin.peminjaman')->with('success', 'Status berhasil diubah!');
    }
}
