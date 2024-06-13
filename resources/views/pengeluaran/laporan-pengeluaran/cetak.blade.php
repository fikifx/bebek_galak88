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
        <img src="{{ asset('images/logo/Bebek galak.png') }}" alt="logo" style="height: 60px; width: auto;" />
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

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengeluaran</th>
                    <th>User Input</th>
                    <th>Tanggal</th>
                    <th>Total Pembayaran</th>
                    <th>Supplayer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluaran as $index => $row)
                    <tr>
                        <td>
                            <p>{{ $index + 1 }}</p>
                        </td>
                        <td>
                            <p>{{ $row->nm_pengeluaran ?? 'null' }}</p>
                        </td>
                        <td>
                            <p>{{ $row->user->name ?? 'null' }}</p>
                        </td>
                        <td>
                            <p>{{ $row->tgl_pengeluaran }}</p>
                        </td>
                        <td>
                            <p>Rp {{ number_format($row->jml_pengeluaran, 0, ',', '.') }}</p>
                        </td>
                        <td>
                            <p>{{ $row->kategori_pengeluaran->nm_kategori_pengeluaran ?? 'null' }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function handlePrint() {
            window.print();

            // Add event listener for after print event
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
