@extends('Pengguna.layouts.main')

@section('container')
    <div class="col-12 mb-3">
        <h4 class="mb-2"><i class="bi bi-box-arrow-up"></i> Disposisi</h4>
        {{-- Session Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex gap-2">

                <a href="{{ url('dashboard/pengguna') }}" class="btn btn-info  mb-3"><i
                        class="bi bi-arrow-left-circle me-2"></i>Kembali</a>


                <a href="{{ url('dashboard/disposisi1/' . $disposisi1->id . '/cetak') }} " class="btn btn-success mb-3"><i
                        class="bi bi-printer me-2"></i>Cetak</a>


                @if (!$disposisi3->selesai)
                    <a href="{{ url('pengguna/disposisis3/create/' . $suratMasuk->id) }} " class="btn btn-primary mb-3"><i
                            class="bi bi-plus-circle me-2"></i>Buat</a>
                @else
                    <a href="{{ url('pengguna/disposisi3/' . $disposisi3->id . '/edit') }} " class="btn btn-warning mb-3"><i
                            class="bi bi-pencil-square me-2"></i>Edit</a>

                    <form action="{{ url('pengguna/disposisi3/' . $disposisi3->id) }}" method="POST">
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
                        <td style="width: 65%">{{ $disposisi1 ? $disposisi1->indek_berkas : '' }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Kode Klasifikasi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">{!! $disposisi1 ? $disposisi1->kode_klasifikasi_arsip : '' !!}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Tanggal Penyelesaian</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi1)
                                {!! $disposisi1->tanggal_penyelesaian ? date('d-m-Y', strtotime($disposisi1->tanggal_penyelesaian)) : '' !!}
                            @endif
                        </td>
                    </tr>

                    <tr>

                        <th scope="row" style="width: 30%">Isi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @php
                                $user2 = App\Models\User::find($disposisi2->user_id);

                            @endphp

                            @php
                                $user3 = App\Models\User::find($disposisi2->disposisi3->user_id);
                            @endphp


                            @if ($disposisi2->selesai)
                                {!! $user2->name . ' : ' . $disposisi2->isi !!}
                            @endif

                            <hr>

                            @if ($disposisi3->selesai)
                                {!! $user3->name . ':' . $disposisi3->isi !!}
                            @endif
                            {{-- {!! auth()->user()->name . ' : ' . $disposisi2->catatan !!} --}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Tanggal</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi1)
                                {!! $disposisi1->tanggal ? date('d-m-Y', strtotime($disposisi1->tanggal)) : '' !!}
                        </td>
                        @endif
                    </tr>
                    <tr>
                        <th scope="row" style="width: 30%">Pukul</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi1 && $disposisi1->pukul)
                                {{-- @if ($disposisi->pukul) --}}
                                {{ $disposisi1->pukul->format('H:i') }}
                                {{-- @endif --}}
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <th scope="row" style="width: 30%">Disampaikan Kepada</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">

                            <p>{{ $user2->name }}</p>

                        </td>
                    </tr> --}}

                    <tr>
                        <th scope="row" style="width: 30%">Selesai</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">

                            @if ($disposisi3->selesai)
                                <span class="badge bg-success">Sudah</span>
                            @else
                                <span class="badge bg-warning">Belum</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th scope="row" style="width: 30%">Verifikasi</th>
                        <td style="width: 5%">:</td>
                        <td style="width: 65%">
                            @if ($disposisi1)
                                @if ($disposisi1->verifikasi_kasubag)
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

    <div class="bg-light rounded h-100 p-4">

        <div class="col-12">
            <h4>Log Surat</h4>

            <div class="bg-light rounded h-100 p-4">

                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>

                            <th scope="row" style="width: 30%">

                                @php
                                    $user1 = App\Models\User::find($disposisi1->user_id);
                                @endphp

                                ({{ date('d-m-Y', strtotime($disposisi1->created_at)) }})
                                {{ $user1->name }} menyampaiakan surat ke</th>
                            <td style="width: 5%">:</td>
                            <td style="width: 65%">

                                <p>{{ $user2->name }}</p>

                                {{-- @php
                                    $diteruskan1 = $disposisi1->diteruskan1;

                                    foreach ($diteruskan1 as $data) {
                                        $arr[] = $data->user_id;
                                    }

                                @endphp

                                @foreach ($users as $user)
                                    @if (in_array($user->id, $arr))
                                        <p>{{ $user->name }}</p>
                                        <br>
                                    @endif
                                @endforeach --}}
                            </td>


                        </tr>

                        <tr>
                            {{-- @if ($disposisi2) --}}
                            <th scope="row" style="width: 30%">
                                ({{ date('d-m-Y', strtotime($disposisi2->created_at)) }})

                                {{ $user2->name }} menyampaikan surat ke
                            </th>
                            <td style="width: 5%">:</td>

                            <td>{{ $user3->name }}</td>

                            {{-- @if ($disposisi2->selesai)
                                @if ($disposisi2->disposisi3)
                                    <th scope="row" style="width: 30%">
                                        ({{ date('d-m-Y', strtotime($disposisi2->created_at)) }})

                                        {{ $user2->name }} menyampaikan surat ke
                                    </th>
                                    <td style="width: 5%">:</td>


                                    @php
                                        $user3 = App\Models\User::find($disposisi2->disposisi3->user_id);
                                    @endphp
                                    <td>{{ $user3->name }}</td>
                                @else
                                    <th scope="row" style="width: 30%">
                                        ({{ date('d-m-Y', strtotime($disposisi2->created_at)) }})

                                        <p>{{ $user2->name }}</p>

                                    </th>

                                    <td style="width: 5%">:</td>

                                    <td>
                                        Selesai
                                    </td>
                                @endif
                            @endif --}}
                            {{-- @endif --}}
                        </tr>

                        @if ($disposisi3->selesai)
                            <tr>
                                <th scope="row" style="width: 30%">
                                    ({{ date('d-m-Y', strtotime($disposisi2->created_at)) }})

                                    {{ $user3->name }}

                                <td style="width: 5%">:</td>
                                <td>Selesai</td>
                                </th>

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
