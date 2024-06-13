@extends('layouts.appNew')

@section('content')
    <div class="form-elements-wrapper pt-5">
        <div class="col-lg-12">
            <!-- input style start -->
            <form class="row needs-validation" novalidate="" action="{{ route('laporan-pengeluaran.store') }}" method="POST">
                @csrf
                <div class="card-style mb-30">
                    <h6 class="mb-25">Tambah Pengeluaran</h6>
                    <div class="select-style-1">
                        <label>Supplayer</label>
                        <div class="select-position">
                            <select name="kd_kategori_pengeluaran" id="kd_kategori_pengeluaran">
                                <option value="">Pilih Supplier</option>
                                @foreach ($kategori_pengeluaran as $item)
                                    <option value="{{ $item->id }}">{{ $item->nm_kategori_pengeluaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- end input -->
                    <div class="input-style-3">
                        <input type="text" placeholder="Nama barang" name="nm_pengeluaran">
                        <span class="icon"><i class="lni lni-package"></i></span>
                    </div>
                    <!-- end input -->
                    <div class="input-style-3">
                        <input type="textarea" placeholder="Catatan" name="catatan">
                        <span class="icon"><i class="lni lni-bookmark-alt"></i></span>
                    </div>
                    <!-- end input -->
                    <div class="input-style-3">
                        <input type="text" id="jml_pengeluaran_display" class="form-control"
                            placeholder="Nominal pengeluaran" />
                        <span class="icon"><i class="lni lni-wallet"></i></span>
                        <input type="hidden" name="jml_pengeluaran" id="jml_pengeluaran">
                    </div>
                    <!-- end input -->
                    <div class="input-style-2">
                        <label>Date</label>
                        <input type="date" id="tgl" name="tgl_pengeluaran">
                    </div>
                    <!-- end input -->

                    <button type="submit" class="main-btn primary-btn btn-hover">
                        Simpan
                    </button>
                    <!-- end button -->
                </div>
            </form>
        </div>

        <!-- end card -->
    </div>
    </div>

    <script>
        function formatRupiah(value) {
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        document.getElementById('jml_pengeluaran_display').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');

            e.target.value = formatRupiah(value);

            document.getElementById('jml_pengeluaran').value = value;
        });

        window.addEventListener('load', function() {
            let hiddenValue = document.getElementById('jml_pengeluaran').value;
            if (hiddenValue) {
                document.getElementById('jml_pengeluaran_display').value = formatRupiah(hiddenValue);
            }
        });
    </script>
@endsection
