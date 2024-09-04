<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi1 extends Model
{
    use HasFactory;

    protected $fillable = ['indek_berkas', 'kode_klasifikasi_arsip', 'tanggal_penyelesaian', 'isi', 'tanggal', 'pukul', 'surat_masuk_id', 'user_id', 'verifikasi_kasubag', 'selesai'];

    protected $casts = [
        'pukul' => 'datetime'
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function disposisi2()
    {
        return $this->hasOne(Disposisi2::class);
    }

}
