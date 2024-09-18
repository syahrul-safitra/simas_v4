<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Disposisi1;
use App\Models\Disposisi2;
use App\Models\Disposisi3;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class Disposisi2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return 'holla';
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SuratMasuk $suratmasuk)
    {
        return view('Pengguna.Disposisi2.create', [
            'suratMasuk' => $suratmasuk->load('disposisi1.disposisi2')
        ]);
    }

    // Show the form for creating a new disposisi2 diteruskan : 
    public function create_diteruskan(SuratMasuk $suratmasuk)
    {
        return view('Pengguna.Disposisi2.create_diteruskan', [
            'users' => User::where('permission', '1')->get(),
            'suratMasuk' => $suratmasuk->load('disposisi1.disposisi2'),
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
            'user_id' => 'required',
            'disposisi2_id' => 'required',
        ]);


        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];
        $editDisposisi1['selesai'] = true;

        $inputDisposisi2['isi'] = $validated['isi'];
        $inputDisposisi2['selesai'] = true;
        $inputDisposisi2['disposisi1_id'] = $validated['disposisi1_id'];
        $inputDisposisi2['user_id'] = $validated['user_id'];

        DB::beginTransaction();
        try {
            Disposisi1::find($validated['disposisi1_id'])->update($editDisposisi1);

            Disposisi2::find($validated['disposisi2_id'])->update($inputDisposisi2);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil dibuat dan disampaikan ke kasubag');
    }

    // Store disposisi2 diteruskan : 
    public function store_disposisi2_diteruskan(Request $request)
    {
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'disposisi1_id' => 'required',
            'user_id' => 'required',
            'disposisi2_id' => 'required',
        ]);

        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];

        $inputDisposisi2['isi'] = $validated['isi'];
        $inputDisposisi2['selesai'] = true;
        $inputDisposisi2['disposisi1_id'] = $validated['disposisi1_id'];

        // Disposisi3 : 
        $inputDisposisi3['user_id'] = $validated['user_id'];
        $inputDisposisi3['disposisi2_id'] = $validated['disposisi2_id'];

        DB::beginTransaction();
        try {
            Disposisi1::find($validated['disposisi1_id'])->update($editDisposisi1);

            Disposisi2::find($validated['disposisi2_id'])->update($inputDisposisi2);

            Disposisi3::create($inputDisposisi3);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil diteruskan!');

    }

    /**
     * Display the specified resource.
     */
    public function show($diposisi1_id)
    {

        $diposisi1 = Disposisi1::find($diposisi1_id);

        $disposisi2 = $diposisi1->disposisi2;

        return view('Pengguna.Disposisi2.index', [
            'suratMasuk' => SuratMasuk::find($diposisi1->surat_masuk_id),
            'disposisi1' => $diposisi1,
            'disposisi2' => $disposisi2->load('disposisi3'),
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi2 $disposisi2)
    {

        $disposisi2 = $disposisi2->load('disposisi1.suratMasuk');

        $surat_masuk_id = $disposisi2->disposisi1->suratMasuk->id;

        return view('Pengguna.Disposisi2.edit', [
            'disposisi2' => $disposisi2,
            'suratMasuk' => SuratMasuk::with('disposisi1.disposisi2')->find($surat_masuk_id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi2 $disposisi2)
    {

        $validated = $request->validate([
            'surat_masuk_id' => 'required',
            'disposisi1_id' => 'required',
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
        ]);

        $editDisposisi1['surat_masuk_id'] = $validated['surat_masuk_id'];
        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];
        // $editDisposisi1['selesai'] = true;

        $inputDisposisi2['isi'] = $validated['isi'];

        DB::beginTransaction();
        try {
            Disposisi1::where('surat_masuk_id', $validated['surat_masuk_id'])->update($editDisposisi1);

            Disposisi2::find($disposisi2->id)->update($inputDisposisi2);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }

        return redirect('pengguna/disposisi2/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil dirubah dan disamppaikan ke kasubag');
    }

    public function edit_disposisi2_diteruskan(Disposisi2 $disposisi2)
    {

        return view('Pengguna.Disposisi2.edit_diteruskan', [
            'suratMasuk' => $disposisi2->load('disposisi1.suratMasuk'),
            'users' => User::where('permission', '1')->get(),
            'disposisi2' => $disposisi2
        ]);
    }

    public function update_disposisi2_diteruskan(Disposisi2 $disposisi2, Request $request)
    {
        $validated = $request->validate([
            'indek_berkas' => '',
            'kode_klasifikasi_arsip' => '',
            'tanggal_penyelesaian' => '',
            'tanggal' => '',
            'pukul' => '',
            'isi' => 'required',
            'disposisi1_id' => 'required',
            'user_id' => 'required',
            'disposisi2_id' => 'required',
            'disposisi3_id' => 'required',
        ]);

        $editDisposisi1['indek_berkas'] = $validated['indek_berkas'];
        $editDisposisi1['kode_klasifikasi_arsip'] = $validated['kode_klasifikasi_arsip'];
        $editDisposisi1['tanggal_penyelesaian'] = $validated['tanggal_penyelesaian'];
        $editDisposisi1['tanggal'] = $validated['tanggal'];
        $editDisposisi1['pukul'] = $validated['pukul'];


        $inputDisposisi2['isi'] = $validated['isi'];
        $inputDisposisi2['selesai'] = true;
        $inputDisposisi2['disposisi1_id'] = $validated['disposisi1_id'];

        // Disposisi3 : 
        $inputDisposisi3['user_id'] = $validated['user_id'];
        $inputDisposisi3['disposisi2_id'] = $validated['disposisi2_id'];

        DB::beginTransaction();
        try {
            Disposisi1::find($validated['disposisi1_id'])->update($editDisposisi1);

            Disposisi2::find($validated['disposisi2_id'])->update($inputDisposisi2);

            Disposisi3::find($validated['disposisi3_id'])->delete();

            Disposisi3::create($inputDisposisi3);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
        return redirect('pengguna/disposisi2/' . $validated['disposisi1_id'])->with('success', 'Disposisi berhasil dirubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi2 $disposisi2)
    {

        if ($disposisi2->disposisi3) {
            $disposisi1_id = $disposisi2->disposisi1->id;

            DB::beginTransaction();
            try {
                Disposisi1::find($disposisi1_id)->update(['selesai' => 0]);
                Disposisi3::destroy($disposisi2->disposisi3->id);
                $disposisi2->update(['selesai' => 0, 'isi' => '']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return back()->with('error', $e->getMessage());
            }
        } else {
            $disposisi1_id = $disposisi2->disposisi1->id;

            DB::beginTransaction();
            try {
                Disposisi1::find($disposisi1_id)->update(['selesai' => 0]);
                $disposisi2->update(['selesai' => 0, 'isi' => '']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return back()->with('error', $e->getMessage());
            }
        }

        return redirect('pengguna/disposisi2/' . $disposisi1_id)->with('success', 'Disposisi berhasil dihapus!');
    }
}
