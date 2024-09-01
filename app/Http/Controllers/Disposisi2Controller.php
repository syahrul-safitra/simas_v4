<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Disposisi1;
use App\Models\Disposisi2;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class Disposisi2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'holla';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SuratMasuk $suratmasuk)
    {
        return view('Pengguna.Disposisi2.create', [
            'suratMasuk' => $suratmasuk->load('disposisi1.diteruskan1')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'surat_masuk_id' => 'required',
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'catatan' => 'required',
            'diteruskan1_id' => 'required'
        ]);

        $editDisposisi1['surat_masuk_id'] = $validated['surat_masuk_id'];
        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];
        $editDisposisi1['selesai'] = true;

        $inputDisposisi2['catatan'] = $validated['catatan'];
        $inputDisposisi2['selesai'] = true;
        $inputDisposisi2['diteruskan1_id'] = $validated['diteruskan1_id'];

        DB::beginTransaction();
        try {
            Disposisi1::where('surat_masuk_id', $validated['surat_masuk_id'])->update($editDisposisi1);

            Disposisi2::create($inputDisposisi2);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/' . $validated['surat_masuk_id'])->with('success', 'Disposisi berhasil dibuat dan disamppaikan ke kasubag');
    }

    /**
     * Display the specified resource.
     */
    public function show($diposisi1_id)
    {

        $diposisi1 = Disposisi1::find($diposisi1_id);

        $disposisi2 = null;

        if (Disposisi2::where('diteruskan1_id', $diposisi1->diteruskan1->first()->id)) {
            $disposisi2 = Disposisi2::where('diteruskan1_id', $diposisi1->diteruskan1->first()->id)->first();
        }

        return view('Pengguna.Disposisi2.index', [
            'suratMasuk' => SuratMasuk::find($diposisi1->surat_masuk_id),
            'disposisi1' => $diposisi1,
            'disposisi2' => $disposisi2,
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi2 $disposisi2)
    {


        $disposisi2 = $disposisi2->load('diteruskan1.disposisi1.suratMasuk');

        $surat_masuk_id = $disposisi2->diteruskan1->disposisi1->suratMasuk->id;

        return view('Pengguna.Disposisi2.edit', [
            'disposisi2' => $disposisi2,
            'suratMasuk' => SuratMasuk::with('disposisi1.diteruskan1')->find($surat_masuk_id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi2 $disposisi2)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required',
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'catatan' => 'required',
            'diteruskan1_id' => 'required'
        ]);

        $editDisposisi1['surat_masuk_id'] = $validated['surat_masuk_id'];
        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];
        $editDisposisi1['selesai'] = true;

        $inputDisposisi2['catatan'] = $validated['catatan'];

        DB::beginTransaction();
        try {
            Disposisi1::where('surat_masuk_id', $validated['surat_masuk_id'])->update($editDisposisi1);

            Disposisi2::find($disposisi2->id)->update($inputDisposisi2);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/' . $validated['surat_masuk_id'])->with('success', 'Disposisi berhasil dirubah dan disamppaikan ke kasubag');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi2 $disposisi2)
    {

        $disposisi1_id = $disposisi2->diteruskan1->disposisi1->id;

        DB::beginTransaction();
        try {
            Disposisi1::find($disposisi1_id)->update(['selesai' => 0]);
            $disposisi2->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/2')->with('success', 'Disposisi berhasil dihapus!');
    }
}
