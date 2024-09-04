<?php

namespace App\Http\Controllers;

use App\Models\Disposisi2;

use Illuminate\Http\Request;

class DashboardPengguna extends Controller
{
    public function index()
    {
        return view('Pengguna.index', [
            'disposisis2' => Disposisi2::with('disposisi1.suratMasuk')->where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }
}
