@extends('Pengguna.layouts.main')

@section('container')
    <div class="col-12">
        <h4 class="mb-2"><i class="bi bi-envelope me-3"></i>Disposisi yang diproses</h4>
        {{-- Session Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="bg-light rounded h-100 p-4">
            <div class="table-responsive">
                <table class="table table-hover" style="color:black">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Asal Surat</th>
                            <th scope="col">Status</th>
                            <th scope="col">File</th>
                            <th scope="col">Disposisi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($disposisis3 as $disposisi3)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $disposisi3->disposisi2->disposisi1->suratMasuk->asal_surat }}</td>
                                <td>{{ $disposisi3->disposisi2->disposisi1->suratMasuk->status }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a class="fs-4" style="color: red"
                                            href="{{ asset('file/' . $disposisi3->disposisi2->disposisi1->suratMasuk->file) }}"><i
                                                class="bi bi-file-earmark-pdf-fill"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('pengguna/disposisi3/' . $disposisi3->disposisi2->disposisi1->id) }}"
                                        class="btn btn-success"
                                        style="padding-top: 2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px"><i
                                            class="bi bi-file-earmark-arrow-up"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection