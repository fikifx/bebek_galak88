@extends('layouts.appNew')

@section('content')
    <br>
    <div class="col-lg-18">
        <div class="tables-wrapper">
            <form method="GET" action="{{ route('detail-transaksi.index') }}">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control datepicker" value="{{ $startDate ?? '' }}"
                            required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control datepicker" value="{{ $endDate ?? '' }}"
                            required>
                    </div>
                    <div class="col-md-3">
                        <button id="filterDate" class="btn btn-success"><i class="lni lni-world-alt"></i>
                            Filter</button>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <a href="{{ route('detail-transaksi.laporan') }}" id="cetakPDF" class="btn btn-primary">
                            <i class="lni lni-printer"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-style mb-30">
            <div class="title d-flex flex-wrap justify-content-between align-items-center">
                <div class="left">
                    <h6 class="text-medium mb-30">Laporan Transaksi Per Menu</h6>
                </div>


                <div class="right">
                    
                </div>
            </div>
            <!-- End Title -->
            <div class="table-responsive">
                <table id="laporanTable" class="table top-selling-table">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <h6 class="text-sm text-medium">No</h6>
                            </th>
                            <th>
                                <h6 class="text-sm text-medium">Nama Menu</h6>
                            </th>
                            <th class="min-width text-center">
                                <h6 class="text-sm text-medium">Quantity Terjual</h6>
                            </th>
                            <th class="min-width">
                                <h6 class="text-sm text-medium">Harga</h6>
                            </th>
                            <th class="min-width">
                                <h6 class="text-sm text-medium">Harga Total Penjualan</h6>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $key => $barang)
                            <tr>
                                <td class="text-center">
                                    <p class="text-sm">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <div class="product">
                                        <p class="text-sm">{{ $barang->nm_barang ?? 'null' }}</p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm">{{ $penjualan[$barang->kd_barang] ?? 0 }}</p>
                                </td>
                                <td>
                                    <p class="text-sm">Rp {{ number_format($barang->hrg_barang, 2, ',', '.') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm">
                                        Rp
                                        {{ number_format(($penjualan[$barang->kd_barang] ?? 0) * $barang->hrg_barang, 2, ',', '.') }}
                                    </p>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            $('#laporanTable').DataTable();

            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endsection
