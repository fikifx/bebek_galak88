@extends('layouts.appNew')

@section('content')
    <!-- ========== Dasboard ========== -->
    @if (auth()->user()->hasRole('super-admin'))
    <section class="section">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30 pb-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h3>Dashboard</h3>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Pengeluaran</h6>
                        <h6 class="text-bold text-success mb-10">Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon orange">
                        <i class="lni lni-pie-chart"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Total Order</h6>
                        <h6 class="text-bold text-success mb-10">{{ $totalTransaksi }} Order</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon primary">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Pendapatan</h6>
                        <h6 class="text-bold text-success mb-10">Rp {{ number_format($jmlTotal, 2, ',', '.') }}</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon success">
                        <i class="lni lni-dollar "></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Laba Bersih</h6>
                        <h6 class="text-bold text-success mb-10">Rp {{ number_format($jmlKembali, 2, ',', '.') }}</h6>
                    </div>
                </div>
            </div>
    </section>
    <!-- ========== Pendapatan Kasir ========== -->
    <section class="section">
        <div class="title-wrapper pt-30 pb-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h3>Pendapatan Kasir</h3>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <div class="content">
                        <h6 class="mb-10">Kasir Malam</h6>
                        <h3 class="text-bold text-success mb-10">Rp
                            {{ number_format($user4Totals['jml_total'], 2, ',', '.') }} </h3>
                        <p class="text-sm text-success">
                            <i class="lni lni-arrow-up"></i> {{ $user4Totals['total_transaksi'] }}
                            <span class="text-gray">(Total Order)</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <div class="content">
                        <h6 class="mb-10">Kasir Pagi</h6>
                        <h3 class="text-bold text-success mb-10">Rp
                            {{ number_format($user3Totals['jml_total'], 2, ',', '.') }} </h3>
                        <p class="text-sm text-success">
                            <i class="lni lni-arrow-up"></i> {{ $user3Totals['total_transaksi'] }}
                            <span class="text-gray">(Total Order)</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    
    <!-- ========== Menu ========== -->
    <section class="section">
        <div class="title-wrapper pt-30 pb-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h3>Menu</h3>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            @php
                $groupedBarangs = $barangs->groupBy('kategori.nm_kategori');
            @endphp

            @foreach ($groupedBarangs as $kategori => $items)
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="card-style p-2  mb-2" style="background-color: #ffffff;">
                        <h3 class="card-title text-center pt-3">{{ $kategori }}</h3>
                        <ul class="list-group list-group-flush">
                            @foreach ($items as $barang)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                <i class="lni lni-tag text-danger" style="font-size: 25px; font-weight: 600"></i>
                                   <p class="fw-600 text-start"> {{ $barang->nm_barang }}</p>
                                    <span class="badge bg-danger p-1"><p style="font-weight: 600; font-size:15px">{{ $barang->stoks->sum('jml_stok') }}</p></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-title {
            font-weight: bold;
            color: #292828;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .form-group h4 {
            font-weight: bold;
        }

        .total-section {
            border-top: 2px solid #007bff;
            padding-top: 10px;
        }

        .table-action-btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table-action-btn button {
            margin: 0 5px;
        }

        .header {
            height: 60px;
            background-color: #ffffff;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
    </style>
@endsection
