@extends('layouts.appNew')

@section('content')
    <br>
    <div class="col-lg-18">
        <div class="card-style mb-30">
            <div class="title d-flex flex-wrap justify-content-between align-items-center">
                <div class="left">
                    <h6 class="text-medium mb-30">List Menu Bebek Galak </h6>
                </div>
                <div class="right">
                    <div class="select-style-1">

                    </div>
                    <!-- end select -->
                </div>
            </div>
            <!-- End Title -->
            <div class="table-responsive">
                <table class="table top-selling-table">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <h6 class="text-sm text-medium">No</h6>
                            </th>
                            <th>
                                <h6 class="text-sm text-medium">Menu</h6>
                            </th>
                            <th class="min-width">
                                <h6 class="text-sm text-medium">Kategori</h6>
                            </th>
                            <th class="min-width">
                                <h6 class="text-sm text-medium">Harga</h6>
                            </th>
                            <th class="text-start">
                                <h6 class="text-sm text-medium">Stock Awal</h6>
                            </th>
                          
                            <th class="text-end">
                                <h6 class="text-sm text-medium">Action</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $key => $barang)
                            <tr>
                                <td class="text-center">
                                    <p class="text-sm">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <div class="product">
                                        <p class="text-sm">{{ $barang->nm_barang }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm">{{ $barang->kategori->nm_kategori }}</p>
                                </td>
                                <td>
                                    <p class="text-sm">Rp {{ number_format($barang->hrg_barang, 2, ',', '.') }}</p>
                                </td>
                                <td class="text-start">
                                    @foreach ($barang->stoks as $stoks)
                                        <p class="text-sm">{{ $stoks->jml_stok }}</p>
                                    @endforeach
                                </td>
                                
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lni lni-more-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                            <li class="dropdown-item">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalDelete{{ $barang->kd_barang }}"
                                                    class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="" class="text-gray" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalupdate-{{ $barang->kd_barang }}">Edit</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="" class="text-gray" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalupdateStok-{{ $barang->kd_barang }}">Edit
                                                    Stok</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Menu Belum Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    {{-- End Body Read Menu indor --}}
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="col-lg-18">
        <div class="card-style settings-card-2 mb-30">
            <div class="title mb-30">
                <h6>Tambah kategori</h6>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Masukan kategori </label>
                            <input type="text" class="form-control" name="nm_kategori" id="nm_kategori"
                                placeholder="Masukan nama kategori" />
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
    <br>
    <div class="col-lg-18">
        <div class="card-style settings-card-2 mb-30">
            <div class="title mb-30">
                <h6>Tambah Menu Bebek Galak</h6>
            </div>
            <form action="{{ route('from.store') }}">
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Pilih Kategori</label>
                            <div class="input-group">
                                <select name="kd_kategori" id="kd_kategori" class="form-control">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategori as $kategoris)
                                        <option value="{{ $kategoris->id }}">{{ $kategoris->nm_kategori }}</option>
                                    @endforeach
                                </select>
                                <button class="main-btn primary-btn btn-hover" type="button" id="button-addon2">Tambah
                                    Kategori</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Nama menu </label>
                            <input type="text" class="form-control" name="nm_barang" id="nm_barang"
                                placeholder="Masukan nama menu" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Harga Barang</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="hrg_barang_display" class="form-control"
                                    placeholder="Masukkan harga menu" />
                                <input type="hidden" name="hrg_barang" id="hrg_barang" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="main-btn primary-btn btn-hover">
                            Tambah menu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- Modal Edit Menu --}}
    @foreach ($barangs as $barang)
        <div class="modal fade" id="exampleModalupdate-{{ $barang->kd_barang }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Update Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="card-style mb-30">


                                <form class="row needs-validation" novalidate=""
                                    action="{{ route('from.update', $barang->kd_barang) }}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label for="f-name" class="form-label">
                                                Menu
                                            </label>
                                            <input type="text" class="form-control" id="nm_barang" name="nm_barang"
                                                placeholder="Masukkan menu" value="{{ $barang->nm_barang }}"
                                                required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label for="hrg_barang" class="form-label"> Nominal </label>
                                            <input type="text" class="form-control" name="hrg_barang"
                                                id="hrg_barang_display" placeholder="Masukkan Nominal"
                                                value="{{ $barang->hrg_barang }}" required="">
                                            <div class="invalid-feedback">
                                                Please Enter a valid Nominal.
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="select-style-1">
                                            <label for="f-name" class="form-label">
                                                Kategori
                                            </label>
                                            <div class="select-position">
                                                <select class="form-control" id="kd_kategori" name="kd_kategori">
                                                    @foreach ($kategori as $row)
                                                        @if ($row->id == $barang->kd_kategori)
                                                            <option value="{{ $row->id }}" selected='selected'>
                                                                {{ $row->nm_kategori }}</option>
                                                        @else
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->nm_kategori }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
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
        </div>
    @endforeach

    {{-- Modal update stok --}}
    @foreach ($barangs as $barang)
        <div class="modal fade" id="exampleModalupdateStok-{{ $barang->kd_barang }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Update Stock {{ $barang->nm_barang }}
                        </h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('stok.update', $barang->kd_barang) }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="kd_barang" value="{{ $barang->kd_barang }}">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Masukan Jumlah stock</label>
                                        <input type="number" name="jml_stok" id="jml_stok"
                                            placeholder="Masuakan jumlah stock" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="main-btn primary-btn btn-hover">
                                            Update stock
                                        </button>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        </div>
    @endforeach

    {{-- Modal Delete Confirmasi --}}
    @foreach ($barangs as $barang)
        <div class="modal fade" id="exampleModalDelete{{ $barang->kd_barang }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu ingin Menghapus Menu {{ $barang->nm_barang }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('from.destroy', $barang->kd_barang) }}" method="post" class="d-inline">
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
    {{-- End Modal --}}
    <style>
        .input-style-1 select {
            height: 60px;
        }
    </style>
    <script>
        function formatRupiah(value) {
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        document.getElementById('hrg_barang_display').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');

            e.target.value = formatRupiah(value);

            document.getElementById('hrg_barang').value = value;
        });
    </script>

    <script>
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script>

@endsection
