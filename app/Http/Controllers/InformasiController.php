<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use File;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Informasi.index', [
            'informasis' => Informasi::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Informasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi' => 'required|max:255',
            'tujuan' => 'required|max:255',
            'file' => 'required'
        ]);

        $file = $request->file('file');

        $renameFile = uniqid() . '_' . $file->getClientOriginalName();

        $tujuan = 'file';

        $file->move($tujuan, $renameFile);

        $validated['file'] = $renameFile;

        Informasi::create($validated);

        return redirect('dashboard/informasi')->with('success', 'Informasi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Informasi $informasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
    {
        return view('Informasi.edit', [
            'informasi' => $informasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        $validated = $request->validate([
            'deskripsi' => 'required|max:255',
            'tujuan' => 'required|max:255',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');

            $renameFile = uniqid() . '_' . $file->getClientOriginalName();

            $validated['file'] = $renameFile;

            // hapus file lama :
            File::delete('file/' . $informasi->file);

            $tujuan_upload = 'file';

            $file->move($tujuan_upload, $renameFile);
        }

        Informasi::find($informasi->id)->update($validated);

        return redirect('dashboard/informasi')->with('success', 'Data informasi berhasil dirubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        Informasi::destroy($informasi->id);

        File::delete('file/' . $informasi->file);

        return redirect('dashboard/informasi')->with('success', 'Data informasi berhasil dihapus!');

    }

    public function lihatInformasi()
    {
        return view('Informasi.lihat', [
            'informasis' => Informasi::all()
        ]);

    }
}
