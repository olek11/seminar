<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data User',
            'menuAdminUser' => 'active',
            'user' => User::get(),
        ];
        return view('admin.user.index', $data); // Make sure the view file resources/views/admin/user/index.blade.php exists
    }

    // bagian route tambah data user
    public function create()
    {
        $data = [
            'title' => 'Tambah Data User',
            'menuAdminUser' => 'active',
            'user' => User::get(),
        ];
        return view('admin.user.create', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'jabatan' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.unique' => 'Email Sudah Ada',
            'jabatan.required' => 'Jabatan Harus Di Pilih',
            'password.required' => 'password Tidak Boleh Kosong',
            'password.confirmed' => 'password Tidak Sama',
            'password.min' => 'password Minimal 6 Karakter',
        ]);

        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->password = Hash::make($request->password); // Make sure the 'password' field in your User model is set to be hashed
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Data Berhasil  Ditambahkan'); // Make sure the route name matches your routes/web.php
    }
    // bagian route edit data user
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data User',
            'menuAdminUser' => 'active',
            'user' => User::findOrFail($id),
        ];
        return view('admin.user.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => "required|unique:users,email,{$id}",
            'jabatan' => 'required',
            'password' => 'nullable|confirmed|min:6',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.unique' => 'Email Sudah Ada',
            'jabatan.required' => 'Jabatan Harus Di Pilih',
            'password.confirmed' => 'password Tidak Sama',
            'password.min' => 'password Minimal 6 Karakter',
        ]);



        $user = User::findOrFail($id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Data Berhasil  Diperbarui'); // Make sure the route name matches your routes/web.php
    }
    // Bagian route untuk hapus data
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'Data Berhasil  Dihapus'); // Make sure the route name matches your routes/web.php
    }
}