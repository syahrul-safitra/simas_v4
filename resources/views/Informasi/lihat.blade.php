<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lihat Informasi</title>

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }} rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        trix-toolbar [data-trix-button-group='file-tools'] {
            display: none;
        }
    </style>

</head>

<body>

    <div class="container-fluid pt-4 px-4">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <h4><i class="far fa-newspaper me-2"></i>Informasi</h4>
                    {{-- pesan success input data :  --}}
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="bg-light rounded h-100 p-4">
                        <div class="table-responsive">
                            <table class="table table-hover" style="color:black" id="table-instansi">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tujuan</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($informasis as $key => $informasi)
                                        <tr>
                                            {{-- <th scope="row">{{ $informasis->firstItem() + $key }}</th> --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $informasi->deskripsi }}</td>
                                            <td>{{ $informasi->tujuan }}</td>
                                            <td> <a class="fs-4" style="color: red" href="{!! asset('file/' . $informasi->file) !!}"><i
                                                        class="bi bi-file-earmark-pdf-fill"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
