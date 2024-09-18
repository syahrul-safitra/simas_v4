<?php

namespace App\Http\Controllers;

use App\Models\Disposisi2;
use App\Models\Disposisi1;
use App\Models\SuratMasuk;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardPengguna extends Controller
{
    public function index()
    {

        // GATE : non-kasubag : 
        $this->authorize('non_kasubag');

        return view('Pengguna.index', [
            'disposisis2' => Disposisi2::with('disposisi1.suratMasuk')->where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }

    public function arsipDisposisi()
    {
        return view('Disposisi.arsip', [
            'disposisis' => Disposisi1::with('suratMasuk')->where('arsipkan', true)->latest()->get()
        ]);
    }

    public function lihatDisposisi(Disposisi1 $disposisi)
    {
        return view('Disposisi.lihat_disposisi_staff', [
            'suratMasuk' => SuratMasuk::find($disposisi->suratMasuk->id),
            'disposisi' => $disposisi,
            'users' => User::all()
        ]);
    }

}
