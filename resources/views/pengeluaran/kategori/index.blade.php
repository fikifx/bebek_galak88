@extends('layouts.appNew')

@section('content')
    <!-- end col -->


    <nav aria-label="breadcrumb">
        <div class="title-wrapper pt-5 pb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Kategori Pengeluaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#0">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Kategori Pengeluaran
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- end col -->

    <div class="col-lg-18">
        <div class="card-style settings-card-2 mb-30">
            <form action="{{ route('pengeluaran.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Masukan kategori </label>
                            <input type="text" class="form-control form-control-defult" name="nm_kategori_pengeluaran"
                                id="nm_kategori_pengeluaran" placeholder="Masukan nama kategori" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="main-btn primary-btn btn-hover">
                            Tambah Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-style clients-table-card mb-30">
                <div class="table-wrapper table-responsive">
                    <div class=""></div>
                    <table class="table clients-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>#</h6>
                                </th>
                                <th>
                                    <h6>Name</h6>
                                </th>

                                <th>
                                    <h6>Action</h6>
                                </th>
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody>
                            @forelse ($kategori_pengeluaran as $key => $pengeluaran)
                                <tr>

                                    <td class="min-width" style="width: 100px">
                                        <p>{{ $key + 1 }}</p>
                                    </td>
                                    <td class="min-width">
                                        <p>{{ $pengeluaran->nm_kategori_pengeluaran }}</p>
                                    </td>

                                    <td>
                                        <div class="action">
                                            <button class="text-primary">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalupdate-{{ $pengeluaran->id }}"><i
                                                        class="lni lni-pencil-alt"></i></a>
                                            </button>
                                            <button class="btn btn-danger text-danger" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalDelete{{ $pengeluaran->id }}">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <p>Tidak ada data pengeluaran</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal pengeluaran edit --}}
    @foreach ($kategori_pengeluaran as $modal_edit_pengeluaran)
        <div class="modal fade" id="exampleModalupdate-{{ $modal_edit_pengeluaran->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="row">

                        <div class="card-style">
                            <div class="title d-flex align-items-center flex-wrap">
                                <p class="mr-40 fw-bold">Edit Kategori Pengeluaran</p>
                            </div>
                            <form class="row needs-validation" novalidate=""
                                action="{{ route('pengeluaran.update', $modal_edit_pengeluaran->id) }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <input type="text" class="form-control form-control-lg"
                                            id="nm_kategori_pengeluaran" name="nm_kategori_pengeluaran"
                                            placeholder="Masukkan nama"
                                            value="{{ $modal_edit_pengeluaran->nm_kategori_pengeluaran }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="button-group d-flex justify-content-center flex-wrap">
                                        <button type="submit" class="main-btn w-100 primary-btn btn-hover m-2">
                                            Perbarui
                                        </button>
                                    </div>
                                </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    </form>
                    <!-- end col -->

                </div>

            </div>
        </div>
    @endforeach


    @foreach ($kategori_pengeluaran as $delete_pengeluaran)
        <div class="modal fade" id="exampleModalDelete{{ $delete_pengeluaran->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu ingin menghapus katagori {{ $delete_pengeluaran->nm_kategori_pengeluaran }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('pengeluaran.destroy', $delete_pengeluaran->id) }}" method="post"
                            class="d-inline">
                            @csrf
                            @method('delete')
                            <!-- Menggunakan metode DELETE -->
                            <button type="submit" class="btn btn-sm btn-danger">
                                <!-- Menggunakan tombol submit -->
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
