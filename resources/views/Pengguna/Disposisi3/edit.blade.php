@extends('Pengguna.layouts.main')

@section('container')
    <form action="{{ url('pengguna/disposisi3/' . $disposisi3->id) }}" method="POST">

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @csrf
        @method('PUT')

        <input type="hidden" name="surat_masuk_id" value="{{ $disposisi3->disposisi2->disposisi1->suratMasuk->id }}">

        <input type="hidden" name="disposisi1_id" value="{{ $disposisi3->disposisi2->disposisi1->id }}">

        <input type="hidden" name="disposisi3_id" value="{{ $disposisi3->id }}">

        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="indek" class="form-label">Indek</label>
                <input type="text" class="form-control @error('indek_berkas') is-invalid @enderror" name="indek_berkas"
                    value="{{ @old('indek_berkas', $disposisi3->disposisi2->disposisi1->indek_berkas) }}" id="indek"
                    autocomplete="off">
                @error('indek_berkas')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="kode" class="form-label">Kode Klasifikasi Arsip</label>
                <input type="text" class="form-control @error('kode_klasifikasi_arsip') is-invalid @enderror"
                    name="kode_klasifikasi_arsip"
                    value="{{ @old('kode_klasifikasi_arsip', $disposisi3->disposisi2->disposisi1->kode_klasifikasi_arsip) }}"
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
                    value="{{ @old('tanggal_penyelesaian', $disposisi3->disposisi2->disposisi1->tanggal_penyelesaian) }}"
                    id="tgl-penyelesaian" autocomplete="off">
                @error('tanggal_penyelesaian')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal"
                    value="{{ @old('tanggal', $disposisi3->disposisi2->disposisi1->tanggal) }}" id="tanggal">
                @error('tanggal')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- row 4 -->
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="kepada" class="form-label">Kepada</label>
                <input type="text" class="form-control @error('kepada') is-invalid @enderror" name="kepada"
                    value="{{ @old('kepada', $disposisi3->disposisi2->disposisi1->kepada) }}" id="kepada"
                    autocomplete="off">
                @error('kepada')
                    <p class="text-danger">{{ $kepada }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="pukul" class="form-label">Pukul</label>
                <input type="time" class="form-control" name="pukul" value="@old('pukul')" id="pukul">
                @error('pukul')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="col-lg-12 mb-3">
            {{-- <label for="">Pesan dari kasubag</label>
            <input type="text" class="form-control" value="{!! $suratMasuk->disposisi1->isi !!}" readonly> --}}
            <label class="form-label">Pesan dari kasubag : </label>
            <div class="readonly">
                {!! date('d-m-Y', strtotime($disposisi3->disposisi2->disposisi1->created_at)) .
                    $disposisi3->disposisi2->disposisi1->isi !!}
            </div>

            <hr>
            @php
                $user2 = App\Models\User::find($disposisi3->disposisi2->user_id);
            @endphp
            <label for="form-label">Pesan dari {{ $user2->name }}</label>
            {!! date('d-m-Y', strtotime($disposisi3->disposisi2->created_at)) . $disposisi3->disposisi2->isi !!}

            <hr>
        </div>


        <!-- row 5 -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <label for="body" class="form-label">Isi <span class="text-danger">*</span></label>
                @error('isi')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="isi" type="hidden" value="{{ old('isi', $disposisi3->isi) }}" name="isi" required>
                <trix-editor input="isi"></trix-editor>

            </div>
            <div class="col-lg-6 mb-3">
            </div>
        </div>

        <a href="{{ url('dashboard/suratmasuk') }}" class="btn btn-warning me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
