<?php

namespace App\Http\Controllers;

use App\Models\Disposisi1;
use App\Models\Disposisi2;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Diteruskan1;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Disposisi1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'hola';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SuratMasuk $suratmasuk)
    {

        return view('Disposisi.create', [
            'users' => User::where('permission', '1')->get(),
            'suratMasuk' => $suratmasuk
        ]);

    }

    public function create_diteruskan(SuratMasuk $suratmasuk)
    {
        return view('Disposisi.create_diteruskan', [
            'users' => User::where('permission', '1')->get(),
            'suratMasuk' => $suratmasuk
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
            'isi' => '',
            'surat_masuk_id' => 'required',
            'user_id' => 'required',
        ]);

        $validated['verifikasi_kasubag'] = true;
        $validated['selesai'] = true;

        try {
            // input data disposisi : 
            Disposisi1::create($validated);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // redirect ke
        return redirect('dashboard/disposisi1/' . $validated['surat_masuk_id'])->with('success', 'Data disposisi berhasil di buat!');
    }

    public function store_disposisi1_diteruskan(Request $request)
    {

        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'surat_masuk_id' => 'required',
            'user_id' => 'required',
            'create_id' => 'required'
        ]);

        $inputDisposisi['indek_berkas'] = $validated['indek_berkas'];
        $inputDisposisi['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $inputDisposisi['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $inputDisposisi['tanggal'] = $validated['tanggal'];
        $inputDisposisi['pukul'] = $validated['pukul'];
        $inputDisposisi['surat_masuk_id'] = $validated['surat_masuk_id'];
        $inputDisposisi['user_id'] = $validated['create_id'];

        // Transaction : 
        DB::beginTransaction();

        try {
            // input data disposisi : 
            $dataDisposisi1 = Disposisi1::create($inputDisposisi);

            // input data disposisi2 pada column user_id : 
            Disposisi2::create([
                'user_id' => $validated['user_id'],
                'disposisi1_id' => $dataDisposisi1->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        // return $dataDisposisi;

        // redirect ke
        return redirect('dashboard/disposisi1/' . $validated['surat_masuk_id'])->with('success', 'Data disposisi berhasil di buat!');
    }

    public function teruskan(Request $request)
    {
        // validation data : 
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'surat_masuk_id' => 'required',
        ]);

        $inputDisposisi['indek_berkas'] = $validated['indek_berkas'];
        $inputDisposisi['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $inputDisposisi['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $inputDisposisi['tanggal'] = $validated['tanggal'];
        $inputDisposisi['pukul'] = $validated['pukul'];
        $inputDisposisi['isi'] = $validated['isi'];
        $inputDisposisi['surat_masuk_id'] = $validated['surat_masuk_id'];

        try {
            // input data disposisi : 
            Disposisi1::create($inputDisposisi);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // redirect ke
        return redirect('dashboard/disposisi1/' . $validated['surat_masuk_id'])->with('success', 'Data disposisi berhasil di buat!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $getDisposisi = null;

        // cek apakah data disposisi ada atau tidak : 
        if (Disposisi1::where('surat_masuk_id', $id)->first()) {
            $getDisposisi = Disposisi1::with('disposisi2.disposisi3')->where('surat_masuk_id', $id)->first();
        }

        return view('Disposisi.index', [
            'suratMasuk' => SuratMasuk::find($id),
            'disposisi' => $getDisposisi,
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi1 $disposisi1)
    {
        return view('Disposisi.edit', [
            'disposisi1' => $disposisi1,
            'suratMasuk' => $disposisi1->suratMasuk
        ]);
    }

    public function edit_disposisi1_diteruskan(Disposisi1 $disposisi1)
    {
        return view('Disposisi.edit_diteruskan', [
            'suratMasuk' => SuratMasuk::where('id', $disposisi1->surat_masuk_id)->first(),
            'disposisi1' => $disposisi1,
            'users' => User::where('permission', 1)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi1 $disposisi1)
    {
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
        ]);

        try {
            Disposisi1::where('id', $disposisi1->id)
                ->update($validated);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect('dashboard/disposisi1/' . $disposisi1->surat_masuk_id)->with('success', 'Disposisi berhasi dirubah!');
    }

    public function update_disposisi1_diteruskan(Request $request, Disposisi1 $disposisi1)
    {

        // NOTE : time to refactor : 

        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'user_id' => 'required',
            'disposisi2_id' => 'required'
        ]);

        $inputDisposisi['indek_berkas'] = $validated['indek_berkas'];
        $inputDisposisi['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $inputDisposisi['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $inputDisposisi['tanggal'] = $validated['tanggal'];
        $inputDisposisi['pukul'] = $validated['pukul'];
        $inputDisposisi['isi'] = $validated['isi'];

        // $disposisi2_user_id = $validated['user_id'];

        DB::beginTransaction();

        try {
            $disposisi1->update($inputDisposisi);

            // hapus data yang disposisi yang lama : 
            Disposisi2::destroy($validated['disposisi2_id']);

            // buat ulang data disposisi 2 :
            Disposisi2::create([
                'user_id' => $validated['user_id'],
                'disposisi1_id' => $disposisi1->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return redirect('dashboard/disposisi1/' . $disposisi1->surat_masuk_id)->with('success', 'Disposisi berhasil dirubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi1 $disposisi1)
    {
        $suratMasukId = $disposisi1->surat_masuk_id;

        // hapus data dari db : 
        Disposisi1::destroy($disposisi1->id);

        // with() :: adalah session yang digunakan untuk mengirim pesan succes atau error saat data telah di inputkan : 
        return redirect('dashboard/disposisi1/' . $suratMasukId)->with('success', 'Disposisi has been deleted!');

    }

    public function verifikasi(Disposisi1 $disposisi1)
    {
        $disposisi1->update(['verifikasi_kasubag' => 1]);

        return redirect('dashboard/disposisi1/' . $disposisi1->surat_masuk_id)->with('success', 'Disposisi telah diverifikasi!');
    }

    public function cetak(Disposisi1 $disposisi1)
    {
        return view('Disposisi.cetak', [
            'disposisi' => $disposisi1,
        ]);
    }

    public function arsipkan(Request $request, Disposisi1 $disposisi1)
    {

        $disposisi1->update([
            'pesan_arsipkan' => $request->pesan_arsipkan,
            'arsipkan' => true
        ]);

        return redirect('dashboard/disposisi1/' . $disposisi1->surat_masuk_id)->with('success', 'Data disposisi telah diarsipkan!');
    }
}
