@extends('layouts.main')

@section('container')
    <div class="col-12">
        <h4 class="mb-2"><i class="bi bi-box-arrow-up"></i> Disposisi</h4>
        {{-- Session Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex gap-2">

                @if (auth()->user()->level == 'master')
                    <a href="{{ url('dashboard/suratmasuk') }}" class="btn btn-info  mb-3"><i
                            class="bi bi-arrow-left-circle me-2"></i>Kembali</a>
                @else
                    <a href="{{ url('dashboard/pengguna') }}" class="btn btn-info  mb-3"><i
                            class="bi bi-arrow-left-circle me-2"></i>Kembali</a>
                @endif

                @if (!$disposisi)
                    <a href="{{ url('dashboard/disposisis1/create/' . $suratMasuk->id) }} " class="btn btn-primary mb-3"><i
                            class="bi bi-plus-circle me-2"></i>Buat</a>

                    <a href="{{ url('dashboard/disposisi1_diteruskan/create_diteruskan/' . $suratMasuk->id) }} "
                        class="btn btn-success mb-3"><i class="fas fa-paper-plane me-2"></i>Teruskan</a>
                @else
                    <a href="{{ url('dashboard/disposisi1/' . $disposisi->id . '/cetak') }} "
                        class="btn btn-success mb-3"><i class="bi bi-printer me-2"></i>Cetak</a>

                    @if ($disposisi->disposisi2)
                        <a href="{{ url('dashboard/disposisis1/' . $disposisi->id . '/edit_disposisi1_diteruskan') }} "
                            class="btn btn-warning mb-3"><i class="bi bi-pencil-square me-2"></i>Edit</a>
                    @else
                        <a href="{{ url('dashboard/disposisi1/' . $disposisi->id) . '/edit' }} "
                            class="btn btn-warning mb-3"><i class="bi bi-pencil-square me-2"></i>Edit</a>
                    @endif

                    @if ($disposisi->selesai)
                        @if (!$disposisi->verifikasi_kasubag)
                            <form action="{{ url('dashboard/disposisi1/' . $disposisi->id) }}" method="POST">
                                @csrf
                                <div class="btn btn btn-success mb-3 " id="btn-verifikasi">
                                    <i class="fas fa-key me-2"></i>Verifikasi
                                </div>
                            </form>
                        @endif
                    @endif

                    <form action="{{ url('dashboard/disposisi1/' . $disposisi->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="btn btn btn-danger mb-3 " id="btn-delete-disposisi">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </div>
                    </form>
                @endif
            </div>
            <table class="table table-striped table-hover">

                <tbody>
                    <tr>
                        <th scope="row" style="width: 30%">Nomor Surat</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{{ $suratMasuk->no_surat }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Asal Surat</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{{ $suratMasuk->asal_surat }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Tanggal Surat</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{{ date('d-m-Y', strtotime($suratMasuk->tanggal_surat)) }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Indek</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{{ $disposisi ? $disposisi->indek_berkas : '' }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Kode Klasifikasi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{!! $disposisi ? $disposisi->kode_klasifikasi_arsip : '' !!}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Tanggal Penyelesaian</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi)
                                {!! $disposisi->tanggal_penyelesaian ? date('d-m-Y', strtotime($disposisi->tanggal_penyelesaian)) : '' !!}
                        </td>
                        @endif

                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Isi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">


                            {{-- {!! $disposisi ? $disposisi->isi : '' !!} --}}

                            {!! $disposisi ? 'Kasubag : ' . $disposisi->isi : '' !!}
                            {{-- pesan ini ditampilkan jika sudah dibuat oleh user lain :  --}}

                            @if ($disposisi)
                                @if ($disposisi->disposisi2)

                                    {{-- @php
                                        $user3 = App\Models\User::find($disposisi->disposisi2->disposisi3->user_id);
                                    @endphp --}}

                                    @if ($disposisi->disposisi2->selesai)
                                        @php
                                            $user2 = App\Models\User::find($disposisi->disposisi2->user_id);

                                        @endphp

                                        <hr>
                                        {!! $user2->name . ':' . $disposisi->disposisi2->isi !!}
                                    @endif


                                    @if ($disposisi->disposisi2->disposisi3)
                                        @if ($disposisi->disposisi2->disposisi3->selesai)
                                            @php
                                                $user3 = App\Models\User::find(
                                                    $disposisi->disposisi2->disposisi3->user_id,
                                                );
                                            @endphp

                                            <hr>
                                            {!! $user3->name . ':' . $disposisi->disposisi2->disposisi3->isi !!}
                                        @endif
                                    @endif
                                @endif
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Kepada</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">



                            {!! $disposisi ? $disposisi->kepada : '' !!}


                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Tanggal</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi)
                                {!! $disposisi->tanggal ? date('d-m-Y', strtotime($disposisi->tanggal)) : '' !!}
                        </td>
                        @endif
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Pukul</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi && $disposisi->pukul)
                                {{-- @if ($disposisi->pukul) --}}
                                {{ $disposisi->pukul->format('H:i') }}
                                {{-- @endif --}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Disampaikan Kepada</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">

                            {{-- @if ($disposisi)
                                @if ($disposisi->disposisi2)
                                    @php
                                        $disampaikan = $disposisi->dis;

                                        foreach ($disampaikan as $value) {
                                            $dataKepada[] = $value->user_id;
                                        }
                                    @endphp
                                    @foreach ($users as $user)
                                        @if (in_array($user->id, $dataKepada))
                                            <p>{{ $user->name }}</p>
                                        @endif
                                    @endforeach
                                @endif

                            @endif --}}
                        </td>
                    </tr>:

                    <tr>
                        <th scope="row" style="width: 30%">Selesai</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">

                            @if ($disposisi)
                                @if ($disposisi->selesai)
                                    <span class="badge bg-success">Sudah</span>
                                @else
                                    <span class="badge bg-warning">Belum</span>
                                @endif
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th scope="row" style="width: 30%">Verifikasi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi)
                                @if ($disposisi->verifikasi_kasubag)
                                    <span class="badge bg-success">Sudah</span>
                                @else
                                    <span class="badge bg-warning">Belum</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if ($disposisi)
        @if ($disposisi->disposisi2)
            <div class="bg-light rounded h-100 p-4">

                <div class="col-12">
                    <h4>Log Surat</h4>

                    <div class="bg-light rounded h-100 p-4">

                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>

                                    <th scope="row" style="width: 30%">

                                        @php
                                            $user = App\Models\User::find($disposisi->user_id);
                                        @endphp


                                        ({{ date('d-m-Y', strtotime($disposisi->created_at)) }})
                                        {{ $user->name }} menyampaiakan surat ke</th>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 65%">
                                        @php

                                            $user2 = App\Models\User::find($disposisi->disposisi2->user_id);

                                        @endphp

                                        <p>{{ $user2->name }}</p>
                                    </td>

                                </tr>

                                <tr>

                                    @if ($disposisi->disposisi2)
                                        @if ($disposisi->disposisi2->selesai)
                                            <th scope="row" style="width: 30%">

                                                ({{ date('d-m-Y', strtotime($disposisi->disposisi2->created_at)) }})
                                                {{ $user2->name }} </th>
                                            <td style="width: 5%">:</td>
                                            <td style="width: 65%">
                                                {!! $disposisi->disposisi2->isi !!}
                                            </td>
                                        @endif
                                    @endif

                                </tr>

                                {{-- <tr>
                                    @if ($disposisi->disposisi2)
                                        @if ($disposisi->disposisi2->selesai)
                                            @if ($disposisi->disposisi2->disposisi3->selesai)
                                                <th scope="row" style="width: 30%">

                                                    ({{ date('d-m-Y', strtotime($disposisi->disposisi2->disposisi3->created_at)) }})
                                                    {{ $user3->name }} </th>
                                                <td style="width: 5%">:</td>
                                                <td style="width: 65%">
                                                    {!! $disposisi->disposisi2->disposisi3->isi !!}
                                                </td>
                                            @endif
                                        @endif
                                    @endif
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
