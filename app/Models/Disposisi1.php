<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi1 extends Model
{
    use HasFactory;

    protected $fillable = ['indek_berkas', 'kode_klasifikasi_arsip', 'tanggal_penyelesaian', 'isi', 'tanggal', 'pukul', 'surat_masuk_id', 'verifikasi_kasubag', 'selesai'];

    protected $casts = [
        'pukul' => 'datetime'
    ];

    public function diteruskan1()
    {
        return $this->hasMany(Diteruskan1::class);
    }

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

}
