@extends('layouts.app_invoice')

@section('content')
    <br>
    <div class="col-xl-4 col-lg-4 col-sm-6">
        <div class="card">
            <div class="container mb-5 mt-3">
                <div class="title d-flex flex-wrap justify-content-between align-items-center">
                    <div class="left">
                        <p style="color: #7e8d9f;font-size: 20px;">Invoice</p>
                    </div>
                    <div class="right">
                        <p style="color: #4f5864;font-size: 20px;">No Antrian : {{ $transaksi->no_antrian }}</p>
                    </div>
                </div>
                <hr>

                <div class="container">
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/logo/Bebek Galak Nota.png') }}" alt="logo"
                                    style="height: 90px; width: auto;" />
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-8">
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#ffffff00;"></i> <span
                                        class="fw-bold">Kasir :</span> {{ $transaksi->user->name }}</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#d1eeff;"></i> <span
                                        class="fw-bold">Waktu :</span> {{ $transaksi->tgl_transaksi }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table top-selling-table">
                            <thead>
                                <tr>
                                    <th>
                                        <h6 class="text-sm text-medium">Menu</h6>
                                    </th>
                                    <th class="min-width">
                                        <h6 class="text-sm text-medium">Qty</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $menu = json_decode($transaksi->menu, true);
                                    $qty = json_decode($transaksi->qty, true);
                                @endphp
                                @if (is_array($menu) && is_array($qty) && count($menu) == count($qty))
                                    @foreach ($menu as $index => $item)
                                        <tr>
                                            <td>
                                                <div class="product">
                                                    <p class="text-sm">{{ $item }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm">{{ $qty[$index] }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">
                                            <p class="text-sm text-danger">Data tidak valid</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="title d-flex flex-wrap justify-content-between align-items-center">
                        <div class="left">
                            <p class="text-sm">Total Transaksi</p>
                            <p class="text-sm">Total Pembayaran</p>
                            <p class="text-sm">Total Pengembalian</p>
                        </div>
                        <div class="right">
                            <p class="text">{{ number_format($transaksi->jml_total, 0, ',', '.') }}</p>
                            <p class="text">{{ number_format($transaksi->jml_bayar, 0, ',', '.') }}</p>
                            <p class="text">{{ number_format($transaksi->jml_kembali, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handlePrint() {
            window.print();

            // Add event listener for after print event
            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    if (!mql.matches) {
                        // Redirect back to previous page when print dialog is closed
                        window.history.back();
                    }
                });
            }
        }
    </script>

    <script>
        // Call the handlePrint function when the page loads
        window.onload = handlePrint;
    </script>

@endsection
