@extends('layouts.appNew')

@section('content')
    <div class="col-lg-12 pt-5">
        @if (auth()->user()->hasRole('super-admin'))
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
                    <a href="{{ route('laporan-pengeluaran.cetak') }}" id="cetakPDF" class="btn btn-primary">
                        <i class="lni lni-printer"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        @endif
        <div class="card-style mb-30">
            <div class="title d-flex justify-content-between">
                <div class="left">
                    <h5 class="text-medium mb-30">Laporan pengeluaran</h5>
                </div>
                <div class="right">
                    <a href="{{ route('laporan-pengeluaran.create') }}" class="btn btn-primary mr-2">Tambah pengeluaran</a>
                </div>
            </div>
            <!-- End Title -->
            <div class="table-responsive">
                <table id="myTable" class="table top-selling-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengeluaran</th>
                            <th>Catatan</th>
                            <th>User Input</th>
                            <th>Tanggal</th>
                            <th>Total Pembayaran</th>
                            <th>Supplier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @if (auth()->user()->hasRole('super-admin'))
        <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Hapus Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu ingin menghapus item ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <form id="formDelete" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Tidak Memiliki Hak Akses Untuk Fitur Ini</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- End Modal -->

    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy'
            });

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan-pengeluaran.index') }}",
                    data: function(d) {
                        d.minDate = $('#minDate').val();
                        d.maxDate = $('#maxDate').val();
                    },
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error to the console for debugging
                    }
                },
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
                        data: 'nm_pengeluaran',
                        name: 'nm_pengeluaran',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'catatan',
                        name: 'catatan',
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
                        data: 'tgl_pengeluaran',
                        name: 'tgl_pengeluaran',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }

                    },
                    {
                        data: 'jml_pengeluaran',
                        name: 'jml_pengeluaran',
                        render: function(data) {
                            return '<p>' + 'Rp ' + parseInt(data).toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }); + '</p>'
                        }
                    },
                    {
                        data: 'kategori_pengeluaran.nm_kategori_pengeluaran',
                        name: 'kategori_pengeluaran.nm_kategori_pengeluaran',
                        render: function(data, type, row) {
                            return '<p>' + data + '</p>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,

                    }
                ],
                order: [
                    [3, 'desc']
                ]
            });

            $('#filterDate').on('click', function() {
                table.draw();
            });

            $('#cetakPDF').on('click', function(e) {
                e.preventDefault();
                var minDate = $('#minDate').val();
                var maxDate = $('#maxDate').val();
                var url = "{{ route('laporan-pengeluaran.cetak') }}";

                if (minDate && maxDate) {
                    url += `?minDate=${minDate}&maxDate=${maxDate}`;
                }

                window.location.href = url;
            });

            // Event delegation for dynamically created delete buttons
            $('#myTable tbody').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var namaPengeluaran = $(this).data('name');
                $('#modalDelete .modal-body').text(`Apakah kamu ingin menghapus ${namaPengeluaran}?`);
                $('#formDelete').attr('action', `{{ url('laporan-pengeluaran/destroy') }}/${id}`);
                $('#modalDelete').modal('show');
            });
        });
    </script>
@endsection
