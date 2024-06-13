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
            @if ($request->has('minDate') && $request->has('maxDate'))
                <h5>Periode Tanggal:</h5>
                <p>{{ $request->minDate }} - {{ $request->maxDate }}</p>
            @endif
        </div>
    </div>
    <p>Total Semua Transaksi: <span id="totalTransaksi">{{ number_format($jmlTotal, 2, ',', '.') }}</span></p>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kasir</th>
                    <th>No Antrian</th>
                    <th>Tanggal</th>
                    <th>Jumlah Total</th>
                    <th>Jumlah Bayar</th>
                    <th>Jumlah Kembali</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $row)
                    <tr>
                        <td>
                            <p>{{ $index + 1 }}</p>
                        </td>
                        <td>
                            <p>{{ $row->user->name ?? 'null' }}</p>
                        </td>
                        <td>
                            <p class="text-center">{{ $row->no_antrian }}</p>
                        </td>
                        <td>
                            <p>{{ $row->tgl_transaksi }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($row->jml_total, 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($row->jml_bayar, 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($row->jml_kembali, 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p class="text-center">{{ $row->kd_metode }}</p>
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