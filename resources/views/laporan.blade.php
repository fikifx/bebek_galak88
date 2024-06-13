@extends('layouts.appnew')

@section('content')
    <br>
    <section class="table-components">
        <div class="">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center pb-3">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Laporan Penjualan</h2>
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
                                        Tables
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tables-wrapper">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="minDate" class="form-control datepicker" placeholder="Dari tanggal">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="maxDate" class="form-control datepicker" placeholder="Sampai tanggal">
                    </div>
                    <div class="col-md-3">
                        <button id="filterDate" class="btn btn-success"><i class="lni lni-world-alt"></i> Filter</button>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <a href="{{ route('transaksi.cetak') }}" id="cetakPDF" class="btn btn-primary">
                            <i class="lni lni-printer"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="table-responsive">
                                <p>Total Semua Transaksi: <span id="totalTransaksi">{{ number_format($totalTransaksi, 2, ',', '.') }}</span></p>
                                <table id="myTable" class="table pb-3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kasir</th>
                                            <th class="text-center">No Antrian</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah Total</th>
                                            <th>Jumlah Bayar</th>
                                            <th>Jumlah Kembali</th>
                                            <th>Metode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="9">
                                                <p>Total Semua Transaksi: Rp <span id="totalTransaksi">{{ number_format($jmlTotal, 2, ',', '.') }}</span></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transaksi.index') }}",
                    data: function(d) {
                        d.minDate = $('#minDate').val();
                        d.maxDate = $('#maxDate').val();
                    },
                    dataSrc: function(json) {
                        $('#totalTransaksi').text(formatRupiah(json.jmlTotal));
                        return json.data;
                    },
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error to the console for debugging
                    }
                },
                order: [
                    [2, 'desc']
                ], // Default order by Tanggal (index 2)
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'user.name',
                        name: 'user.name',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'no_antrian',
                        name: 'no_antrian',
                        render: function(data, type, row) {
                            return '<p class="text-center">' + data + '</p>';
                        }
                    },
                    {
                        data: 'tgl_transaksi',
                        name: 'tgl_transaksi',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'jml_total',
                        name: 'jml_total',
                        render: function(data, type, row) {
                            return '<p>' + formatRupiah(data) + '</p>';
                        }
                    },
                    {
                        data: 'jml_bayar',
                        name: 'jml_bayar',
                        render: function(data, type, row) {
                            return '<p>' + formatRupiah(data) + '</p>';
                        }
                    },
                    {
                        data: 'jml_kembali',
                        name: 'jml_kembali',
                        render: function(data, type, row) {
                            return '<p>' + formatRupiah(data) + '</p>';
                        }
                    },
                    {
                        data: 'kd_metode',
                        name: 'kd_metode',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filterDate').on('click', function() {
                table.draw();
            });

            $('#cetakPDF').on('click', function(e) {
                e.preventDefault();
                var minDate = $('#minDate').val();
                var maxDate = $('#maxDate').val();
                var url = "{{ route('transaksi.cetak') }}";

                if (minDate && maxDate) {
                    url += `?minDate=${minDate}&maxDate=${maxDate}`;
                }

                window.location.href = url;
            });

            function formatRupiah(amount) {
                var numberString = amount.toString(),
                    remainder = numberString.length % 3,
                    rupiah = numberString.substr(0, remainder),
                    thousands = numberString.substr(remainder).match(/\d{3}/g);

                if (thousands) {
                    var separator = remainder ? '.' : '';
                    rupiah += separator + thousands.join('.');
                }

                return 'Rp ' + rupiah + ',00';
            }
        });
    </script>
@endsection
