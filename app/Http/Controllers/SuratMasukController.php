<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('SuratMasuk.index', [
            'suratMasuks' => SuratMasuk::latest()->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataStatus = ['diketahui', 'dihadiri', 'ditindak lanjuti(proses)'];
        $dataSifat = ['biasa', 'penting', 'rahasia'];
        return view('SuratMasuk.create', [
            'statuss' => $dataStatus,
            'sifats' => $dataSifat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_masuks|max:255',
            'tanggal_surat' => 'required',
            'tanggal_diterima' => 'required',
            'sifat' => 'required',
            'isi_ringkas' => 'required',
            'status' => 'required',
            'asal_surat' => 'required',
            'file' => 'required|max:3072'
        ]);

        // get file : 
        $file = $request->file('file');

        // ubah nama berkas menggunakan str:random + originNamaBerkas : 
        $renameNamaFile = uniqid() . '_' . $file->getClientOriginalName();

        // ubah nama berkas pada validated : 
        $validated['file'] = $renameNamaFile;

        // simpan data kedalam DB : 
        SuratMasuk::create($validated);

        // buat variable nama folder : 
        $tujuan_upload = 'file';

        // lalu pindahkan : 
        $file->move($tujuan_upload, $renameNamaFile);

        return redirect('dashboard/suratmasuk')->with('success', 'Surat Masuk has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $dataStatus = ['diketahui', 'dihadiri', 'ditindak lanjuti(proses)'];
        $dataSifat = ['biasa', 'penting', 'rahasia'];
        return view('dashboardSuratMasuk.edit', [
            'suratMasuk' => $suratMasuk,
            'statuss' => $dataStatus,
            'sifats' => $dataSifat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        // buat rules : 
        $rules = [
            'tanggal_surat' => 'required',
            'tanggal_diterima' => 'required',
            'asal_surat' => 'required',
            'status' => 'required',
            'sifat' => 'required',
            'isi_ringkas' => 'required',
            'file' => 'file|max:3072'
        ];


        // cek apakah no surat diubah : 
        if ($request->no_surat != $suratMasuk->no_surat) {
            // masukan kedalam rules : 
            $rules['no_surat'] = 'required|unique:surat_masuks|max:255';
        }

        // validasi terlebih dahulu : 
        $validated = $request->validate($rules);

        // cek apakah file di ubah : 
        if ($request->file('file')) {
            // get file :
            $file = $request->file('file');

            $renameNamaFile = uniqid() . '_' . $file->getClientOriginalName();

            // ubah nama berkas pada validated :
            $validated['file'] = $renameNamaFile;

            // hapus file lama : 
            File::delete('file/' . $suratMasuk->file);

            // pindah kan file :
            // buat variable nama folder : 
            $tujuan_upload = 'file';

            // lalu pindahkan : 
            $file->move($tujuan_upload, $renameNamaFile);
        }

        // simpan data kedalam DB : 
        SuratMasuk::where('id', $suratMasuk->id)
            ->update($validated);

        return redirect('dashboard/suratmasuk')->with('success', 'Surat Masuk has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        // hapus data file terlebih dahulu : 
        File::delete('file/' . $suratMasuk->file);

        // hapus data dari db : 
        SuratMasuk::destroy($suratMasuk->id);

        // with() :: adalah session yang digunakan untuk mengirim pesan succes atau error saat data telah di inputkan : 
        return redirect('dashboard/suratmasuk')->with('success', 'Surat telah dihapus!');
    }
}