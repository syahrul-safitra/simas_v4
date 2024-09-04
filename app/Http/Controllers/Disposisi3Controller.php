<?php

namespace App\Http\Controllers;

use App\Models\Disposisi1;
use App\Models\Disposisi3;
use App\Models\SuratMasuk;
use App\Models\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Disposisi3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Pengguna.Disposisi3.index', [
            'disposisis3' => Disposisi3::with('disposisi2.disposisi1.suratMasuk')->where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SuratMasuk $suratmasuk)
    {
        return view('Pengguna.Disposisi3.create', [
            'suratMasuk' => $suratmasuk->load('disposisi1.disposisi2')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'disposisi1_id' => 'required',
            'disposisi3_id' => 'required',
        ]);

        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];
        $editDisposisi1['selesai'] = true;

        $inputDisposisi3['isi'] = $validated['isi'];
        $inputDisposisi3['selesai'] = true;

        DB::beginTransaction();
        try {
            Disposisi1::find($validated['disposisi1_id'])->update($editDisposisi1);

            Disposisi3::find($validated['disposisi3_id'])->update($inputDisposisi3);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi3/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil dibuat dan dikembalikan kepada kasubag');

    }

    /**
     * Display the specified resource.
     */
    public function show($disposisi1_id)
    {

        $disposisi1 = Disposisi1::find($disposisi1_id);

        $disposisi2 = $disposisi1->disposisi2;

        return view('Pengguna.Disposisi3.show', [
            'suratMasuk' => SuratMasuk::find($disposisi1->surat_masuk_id),
            'disposisi1' => $disposisi1,
            'disposisi2' => $disposisi2,
            'disposisi3' => $disposisi2->disposisi3,
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi3 $disposisi3)
    {
        $disposisi3 = $disposisi3->load('disposisi2.disposisi1.suratMasuk');

        return view('Pengguna.Disposisi3.edit', [
            'disposisi3' => $disposisi3
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi3 $disposisi3)
    {
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'disposisi1_id' => 'required',
            'disposisi3_id' => 'required',
        ]);

        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];

        $editDisposisi3['isi'] = $validated['isi'];

        DB::beginTransaction();
        try {
            Disposisi1::find($validated['disposisi1_id'])->update($editDisposisi1);

            Disposisi3::find($validated['disposisi3_id'])->update($editDisposisi3);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi3/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil dirubah dan dikembalikan kepada kasubag');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi3 $disposisi3)
    {
        DB::beginTransaction();

        try {

            Disposisi1::find($disposisi3->disposisi2->disposisi1->id)->update(['selesai' => 0, 'verifikasi_kasubag' => 0]);

            $disposisi3->update(['selesai' => 0, 'isi' => '']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi3/' . $disposisi3->disposisi2->disposisi1->id)->with('success', 'Disposisi berhasil dihapus!');
    }
}
