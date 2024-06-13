<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Bebek Galak') }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @vite('resources/sass/app.scss')
</head>

<body>
    <section class="section">
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- end container -->
    </section>
    @vite('resources/js/app.js')
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil semua tombol dengan kelas main-btn
            var buttons = document.querySelectorAll(".main-btn");

            // Tambahkan event listener untuk setiap tombol
            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    // Hapus kelas active-btn-outline dari semua tombol
                    buttons.forEach(function(btn) {
                        btn.classList.remove("active-btn-outline");
                    });

                    // Tambahkan kelas active-btn-outline ke tombol yang diklik
                    this.classList.add("active-btn-outline");
                });
            });
        });
    </script>



</body>

</html>
