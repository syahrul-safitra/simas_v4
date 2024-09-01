<?php

namespace App\Http\Controllers;

use App\Models\Diteruskan1;

use Illuminate\Http\Request;

class DashboardPengguna extends Controller
{
    public function index()
    {
        return view('Pengguna.index', [
            'diteruskan1' => Diteruskan1::with('disposisi1.suratMasuk')->where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }
}
