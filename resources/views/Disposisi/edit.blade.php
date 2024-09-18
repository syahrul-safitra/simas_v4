@extends('layouts.main')

@section('container')
    <form action="{{ url('dashboard/disposisi1/' . $disposisi1->id) }}" method="POST">

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @csrf
        @method('PUT')
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
                <label for="indek" class="form-label">Indek <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('indek_berkas') is-invalid @enderror" name="indek_berkas"
                    value="{{ @old('indek_berkas', $disposisi1->indek_berkas) }}" id="indek" autocomplete="off">
                @error('indek_berkas')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="kode" class="form-label">Kode Klasifikasi Arsip <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="kode_klasifikasi_arsip"
                    value="{{ @old('kode_klasifikasi_arsip', $disposisi1->kode_klasifikasi_arsip) }}" id="kode">
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
                    value="{{ @old('tanggal_penyelesaian', $disposisi1->tanggal_penyelesaian) }}" id="tgl-penyelesaian"
                    autocomplete="off">
                @error('tanggal_penyelesaian')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal"
                    value="{{ @old('tanggal', $disposisi1->tanggal) }}" id="tanggal">
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
                    value="{{ @old('kepada', $disposisi1->kepada) }}" id="kepada" autocomplete="off">
                @error('kepada')
                    <p class="text-danger">{{ $kepada }}</p>
                @enderror
            </div> --}}
            <div class="col-lg-6 mb-3">
                <label for="pukul" class="form-label">Pukul</label>
                {{-- @dd($disposisi->pukul->format('H:i')); --}}

                @if ($disposisi1->pukul)
                    <input type="time" class="form-control" name="pukul"
                        value="{{ @old('pukul', $disposisi->pukul->format('H:i')) }}" id="pukul">
                @else
                    <input type="time" class="form-control" name="pukul" value="{{ @old('pukul') }}" id="pukul">
                @endif
                @error('pukul')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- row 5 -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <label for="body" class="form-label">Isi <span class="text-danger">*</span></label>
                @error('pesan_arsipkan')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="pesan_arsipkan" type="hidden" value="{{ old('pesan_arsipkan', $disposisi1->pesan_arsipkan) }}"
                    name="pesan_arsipkan" required>
                <trix-editor input="pesan_arsipkan"></trix-editor>
            </div>
            <div class="col-lg-6 mb-3">
            </div>
        </div>


        {{-- row 6 --}}
        {{-- <div class="row ">
            <div class="col-lg-12 mb-3">
                <label for="" class="form-label">Disampaikan Kepada <span class="text-danger">*</span></label>
                @error('diketahui')
                    <div class="alert alert-danger">
                        {{ 'Mohon input check-box minimal 1' }}
                    </div>
                @enderror
                @php
                    foreach ($disposisi->disampaikanKepada as $user) {
                        $disampaikan[] = $user->user_id;
                    }
                @endphp
                @foreach ($users as $user)
                    <div class="d-block">
                        <input type="checkbox" class="form-check-input" value="{{ $user->id }}"
                            name="disampaikan_kepada[]"
                            {{ @old('diketahui', $disampaikan) ? (in_array($user->id, $disampaikan) ? 'checked' : '') : '' }}>
                        <label class="form-check-label" for="{{ $user->name }}">{{ $user->name }}</label>
                    </div>
                @endforeach
            </div>
        </div> --}}

        <a href="{{ url('dashboard/disposisi1/' . $suratMasuk->id) }}" class="btn btn-warning me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>


    {{-- ----------------------------------------------------------------------------------------- --}}
    {{-- Script JS --}}
    <script>
        // trix js : 
        document.addEventListener('trix-file-accept', function() {
            e.preventDefault();
        });
    </script>
@endsection
