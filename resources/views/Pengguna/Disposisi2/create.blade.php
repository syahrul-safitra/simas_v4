@extends('Pengguna.layouts.main')

@section('container')
    <form action="{{ url('pengguna/disposisi2') }}" method="POST">

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @csrf

        <input type="hidden" name="disposisi1_id" value="{{ $suratMasuk->disposisi1->id }}">

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <input type="hidden" name="disposisi2_id" value="{{ $suratMasuk->disposisi1->disposisi2->id }}">
        <!-- row 1 -->
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="no-surat" class="form-label">No Surat</label>
                <input type="text" class="form-control" value="{{ $suratMasuk->no_surat }}" id="no-surat"
                    autocomplete="off" readonly>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="asal-surat" class="form-label">Asal Surat</label>
                <input type="text" class="form-control" value="{{ $suratMasuk->asal_surat }}" id="asal-surat"
                    autocomplete="off" readonly>
            </div>

        </div>
        <!-- row 2 -->
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="indek" class="form-label">Indek</label>
                <input type="text" class="form-control @error('indek_berkas') is-invalid @enderror" name="indek_berkas"
                    value="{{ @old('indek_berkas', $suratMasuk->disposisi1->indek_berkas) }}" id="indek"
                    autocomplete="off">
                @error('indek_berkas')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="kode" class="form-label">Kode Klasifikasi Arsip</label>
                <input type="text" class="form-control @error('kode_klasifikasi_arsip') is-invalid @enderror"
                    name="kode_klasifikasi_arsip"
                    value="{{ @old('kode_klasifikasi_arsip', $suratMasuk->disposisi1->kode_klasifikasi_arsip) }}"
                    id="kode">
                @error('kode_klasifikasi_arsip')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- row 3 -->
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="tgl-penyelesaian" class="form-label">Tanggal Penyelesaian</label>
                <input type="date" class="form-control @error('tanggal_penyelesaian') is-invalid @enderror"
                    name="tanggal_penyelesaian"
                    value="{{ @old('tanggal_penyelesaian', $suratMasuk->disposisi1->tanggal_penyelesaian) }}"
                    id="tgl-penyelesaian" autocomplete="off">
                @error('tanggal_penyelesaian')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal"
                    value="{{ @old('tanggal', $suratMasuk->disposisi1->tanggal) }}" id="tanggal">
                @error('tanggal')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- row 4 -->
        <div class="row">
            {{-- <div class="col-lg-6 mb-3">
                <label for="kepada" class="form-label">Kepada</label>
                <input type="text" class="form-control @error('kepada') is-invalid @enderror" name="kepada"
                    value="{{ @old('kepada', $suratMasuk->disposisi1->kepada) }}" id="kepada" autocomplete="off">
                @error('kepada')
                    <p class="text-danger">{{ $kepada }}</p>
                @enderror
            </div> --}}
            <div class="col-lg-6 mb-3">
                <label for="pukul" class="form-label">Pukul</label>
                <input type="time" class="form-control" name="pukul" value="@old('pukul')" id="pukul">
                @error('pukul')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- row 5 -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <label for="body" class="form-label">Isi <span class="text-danger">*</span></label>
                @error('isi')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="isi" type="hidden" value="{{ old('isi') }}" name="isi" required>
                <trix-editor input="isi"></trix-editor>
            </div>
            <div class="col-lg-6 mb-3">
            </div>
        </div>

        <a href="{{ url('dashboard/suratmasuk') }}" class="btn btn-warning me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
