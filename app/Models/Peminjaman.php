<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peminjaman';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ruang_id', 'tanggal_peminjaman', 'waktu_mulai', 'waktu_selesai', 'status', 'name', 'NIM', 'jurusan', 'user_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_peminjaman' => 'date', // Cast ke tipe date
        'waktu_mulai' => 'datetime',   // Cast ke tipe waktu
        'waktu_selesai' => 'datetime', // Cast ke tipe waktu
        'status' => 'string',          // Cast ke string untuk enum
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the ruang that owns the peminjaman.
     */
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }
}
