<!-- view cetak (laporan-items.print) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
    @vite('resources/sass/app.scss')
</head>

<body onload="handlePrint()">
    <div class="text-center">
        <img src="{{ asset('images/logo/Bebek Galak Nota.png') }}" alt="logo" style="height: 90px; width: auto;" />
    </div>

    <h1 class="text-center pt-2">Laporan Transaksi</h1>
    <div>
        <div class="pt-4">
            @if ($startDate && $endDate)
                <h5>Periode Tanggal:</h5>
                <p>{{ $startDate }} - {{ $endDate }}</p>
            @endif
        </div>
    </div>
    <p>Total Semua Transaksi: <span id="totalTransaksi">{{ number_format($totalTransaksi, 2, ',', '.') }}</span></p>
    <div class="table-responsive">
        <table class="table">
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
                @foreach ($penjualan as $key => $detail)
                    <tr>
                        <td class="text-center">
                            <p class="text-sm">{{ $key + 1 }}</p>
                        </td>
                        <td>
                            <div class="product">
                                <p class="text-sm">{{ $detail->barang->nm_barang ?? 'null' }}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="text-sm">{{ $detail->total_quantity }}</p>
                        </td>
                        <td>
                            <p class="text-sm">Rp {{ number_format($detail->barang->hrg_barang, 2, ',', '.') }}</p>
                        </td>
                        <td>
                            <p class="text-sm">
                                Rp
                                {{ number_format($detail->total_quantity * $detail->barang->hrg_barang, 2, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function handlePrint() {
            window.print();

            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    if (!mql.matches) {
                        window.history.back();
                    }
                });
            }
        }
    </script>
</body>

</html>
