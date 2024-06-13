@extends('layouts.app_kasir')

@section('content')
    <!-- ========== Menu ========== -->
    <div class="title-wrapper pt-30 pt-6">
        <div class="row align-items-center">

        </div>
        <!-- end row -->
    </div>
    <div class="row">
        @php
            $groupedBarangs = $barangs->groupBy('kategori.nm_kategori');
        @endphp

        @foreach ($groupedBarangs as $kategori => $items)
            <div class="col-xl-3 col-lg-3 col-sm-12">
                <div class="card-style p-4  mb-4" style="background-color: #ffffff;">
                    <h5 class="card-title">{{ $kategori }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($items as $barang)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-nama="{{ $barang->nm_barang }}"
                                data-harga="{{ number_format($barang->hrg_barang, 2, ',', '.') }}"
                                onclick="addToTransaction('{{ $barang->nm_barang }}', '{{ number_format($barang->hrg_barang, 2, ',', '.') }}')">
                                {{ $barang->nm_barang }}
                                {{-- <span class="badge bg-primary">Rp
                                    {{ number_format($barang->hrg_barang, 2, ',', '.') }}</span> --}}
                                <span class="badge bg-danger">{{ $barang->stoks->sum('jml_stok') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    <!-- ========== Transaksi ========== -->
    <div class="card-style shadow-sm p-4 mb-3" style="background-color: #ffffff;">
        <h5 class="card-title text-left">Transaksi</h5>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th style="width: 80px">Qty</th>
                    <th>Harga Per Unit</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="transaction-table-body"></tbody>
        </table>
        <div class="total-section d-flex justify-content-between align-items-center mt-4">
            <div>
                <h6>Total Semua Transaksi</h6>
            </div>
            <div>
                <h4 id="jml_total" class="text-success">Rp 0</h4>
            </div>
        </div>
    </div>

    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        </div>
        <div class="right">
            <div class="">
                <div class="card-style p-3 mb-3 text-left" style="background-color: #ffffff;">
                    <div class="form-group">
                        <label for="discount">Diskon (%)</label>
                        <input type="number" class="form-control" id="discount" name="discount"
                            placeholder="Masukkan Diskon">
                    </div>

                    <button class="btn btn-danger btn-lg" onclick="submitTransaction()">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <form id="transaction-form" method="POST" action="{{ route('transaksi.store') }}">
        @csrf
        <input type="hidden" name="tgl_transaksi" value="{{ date('Y-m-d') }}">
        <input type="hidden" id="jml_total_input" name="jml_total">
        <input type="hidden" id="jml_bayar_input" name="jml_bayar">
        <input type="hidden" id="jml_kembali_input" name="jml_kembali">
        <input type="hidden" id="menu_input" name="menu">
        <input type="hidden" id="qty_input" name="qty">
        <input type="hidden" id="kd_metode_input" name="kd_metode">
    </form>

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Transaksi</h5>

                </div>
                <div class="modal-body">
                    <h6>Detail Pesanan</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Qty</th>
                                <th>Harga Per Unit</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="modal-transaction-table-body"></tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span class="text-success text-bold" id="modal-total-transaction"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="modal-jml_bayar">Nominal Pembayaran</label>
                        <input type="text" class="form-control" id="modal-jml_bayar" name="modal_jml_bayar"
                            placeholder="Rp " autofocus>
                    </div>
                    @php
                        use App\Models\MetodePembayaran;
                        $metode_pembayaran = MetodePembayaran::all();
                    @endphp
                    <div class="form-group">
                        <label for="kd_metode">Metode Pembayaran</label>
                        <select name="kd_metode" id="kd_metode" class="form-control" required>
                            @foreach ($metode_pembayaran as $metode)
                                <option value="{{ $metode->nm_metode_pembayaran }}">{{ $metode->nm_metode_pembayaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal-jml_kembali">Total Kembalian</label>
                        <div class="form-group">
                            <h4 id="modal-jml_kembali" class="text-danger">Rp 0</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmTransactionButton">Konfirmasi &
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('modal-jml_bayar').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = formatRupiah(value);
            calculateChange();
        });

        const searchField = document.querySelector('#quantityInput');
        window.addEventListener('keyup', (e) => {
            if ((e.code === 'Slash') && (document.activeElement.tagName !== 'INPUT') && (document.activeElement
                    .tagName !== 'TEXTAREA')) {
                searchField.focus();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            let currentMenuIndex = -1;
            const menuItems = document.querySelectorAll('.list-group-item');

            document.addEventListener('keydown', function(event) {
                switch (event.code) {
                    case 'ArrowDown':
                        event.preventDefault();
                        currentMenuIndex = (currentMenuIndex + 1) % menuItems.length;
                        updateMenuSelection();
                        break;

                    case 'ArrowUp':
                        event.preventDefault();
                        currentMenuIndex = (currentMenuIndex - 1 + menuItems.length) % menuItems.length;
                        updateMenuSelection();
                        break;

                    case 'ArrowRight':
                        event.preventDefault();
                        currentMenuIndex = (currentMenuIndex + 1) % menuItems.length;
                        updateMenuSelection();
                        break;

                    case 'ArrowLeft':
                        event.preventDefault();
                        currentMenuIndex = (currentMenuIndex - 1 + menuItems.length) % menuItems.length;
                        updateMenuSelection();
                        break;

                    case 'Space':
                        if (currentMenuIndex >= 0 && currentMenuIndex < menuItems.length) {
                            event.preventDefault();
                            const selectedMenuItem = menuItems[currentMenuIndex];
                            const nmBarang = selectedMenuItem.getAttribute('data-nama');
                            const hrgBarang = selectedMenuItem.getAttribute('data-harga');
                            addToTransaction(nmBarang, hrgBarang);
                        }
                        break;

                    case 'Enter':
                        event.preventDefault();
                        const confirmationModal = document.getElementById('confirmationModal');
                        const isModalOpen = confirmationModal.classList.contains('show');

                        if (isModalOpen) {
                            document.getElementById('confirmTransactionButton').click();
                        } else {
                            submitTransaction();
                        }
                        break;

                    case 'Backspace':
                        if (document.activeElement.tagName !== 'INPUT') {
                            event.preventDefault();
                            const rows = document.querySelectorAll("#transaction-table-body tr");
                            if (rows.length > 0) {
                                const rowIndexToRemove = rows.length - 1;
                                removeFromTransaction(rows[rowIndexToRemove].querySelector('button'));
                            }
                        }
                        break;



                    default:
                        break;
                }
            });

            function updateMenuSelection() {
                menuItems.forEach((item, index) => {
                    item.classList.toggle('active', index === currentMenuIndex);
                });
            }
        });

        function addToTransaction(namaMenu, hargaPerUnit) {
            var tableBody = document.getElementById("transaction-table-body");
            var newRow = document.createElement("tr");

            newRow.innerHTML = `
        <td>${namaMenu}</td>
        <td class="d-flex justify-content-center align-items-center" style="width: 150px; border:none;">
            <button class="btn btn-success btn-sm me-1" onclick="decrementQty(this)"><i class="fas fa-minus"></i></button>
            <input type="number" class="form-control quantity qtyInput text-center"  onchange="calculateSubtotal(this)" style="border: none; width: 50px;" id="quantityInput">
            <button class="btn btn-success btn-sm ms-1" onclick="incrementQty(this)"><i class="fas fa-plus"></i></button>
        </td>

        <td class="harga-per-unit">Rp ${hargaPerUnit}</td>
        <td> <span class="total-price">${hargaPerUnit}</span></td>
        <td><button class="btn btn-danger btn-sm" onclick="removeFromTransaction(this)"><i class="fas fa-times"></i></button></td>
    `;



            tableBody.appendChild(newRow);

            const qtyInputs = document.querySelectorAll('.qtyInput');
            const newQtyInput = qtyInputs[qtyInputs.length - 1];
            newQtyInput.focus();

            newQtyInput.addEventListener('input', function() {
                updateTransactionRowTotal(newRow);
            });

            calculateTotal();



            // Menandai item menu yang sudah dipilih
            var selectedMenuItem = document.querySelector(`[data-nama="${namaMenu}"]`);
            selectedMenuItem.setAttribute('data-selected', 'true');
        }

        function removeFromTransaction(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateTotal();
            var namaMenu = row.children[0].textContent;
            var selectedMenuItem = document.querySelector(`[data-nama="${namaMenu}"]`);
            selectedMenuItem.setAttribute('data-selected', 'false');
        }

        function incrementQty(button) {
            const input = button.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            calculateSubtotal(input);
        }

        function decrementQty(button) {
            const input = button.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                calculateSubtotal(input);
            }
        }

        function calculateSubtotal(input) {
            var row = input.parentNode.parentNode;
            var priceText = row.querySelector(".harga-per-unit").textContent;
            var price = parseFloat(priceText.replace("Rp ", "").replace(/\./g, "").replace(",", "."));
            var quantity = parseInt(input.value);
            var subtotal = price * quantity;
            row.querySelector(".total-price").textContent = "Rp " + subtotal.toLocaleString("id-ID");
            calculateTotal();
        }

        function calculateTotal() {
            var total = 0;
            var rows = document.querySelectorAll("#transaction-table-body tr");
            rows.forEach(function(row) {
                var priceText = row.querySelector(".total-price").textContent;
                var price = parseFloat(priceText.replace("Rp ", "").replace(/\./g, "").replace(",", "."));
                total += price;
            });
            document.getElementById("jml_total").innerText = "Rp " + total.toLocaleString("id-ID");
            calculateChange();
        }

        function calculateChange() {
            var discount = parseFloat(document.getElementById("discount").value) || 0;
            var jml_bayar_text = document.getElementById("modal-jml_bayar").value.replace("Rp ", "").replace(/\./g, "");
            var jml_bayar = parseFloat(jml_bayar_text) || 0;
            var totalText = document.getElementById("jml_total").innerText;
            var total = parseFloat(totalText.replace("Rp ", "").replace(/\./g, "").replace(",", "."));
            var totalAfterDiscount = total - (total * (discount / 100));
            var jml_kembali = jml_bayar - totalAfterDiscount;
            document.getElementById("modal-jml_kembali").textContent = "Rp " + jml_kembali.toLocaleString("id-ID");
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById("confirmTransactionButton").addEventListener("click", (event) => {
                const form = document.getElementById('transaction-form');
                const jml_kembali_text = document.getElementById("modal-jml_kembali").textContent;
                const jml_kembali = parseFloat(jml_kembali_text.replace("Rp ", "").replace(/\./g, "")
                    .replace(",", "."));

                if (jml_kembali < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Jumlah bayar tidak cukup. Harap cek kembali.',
                        timer: 1000
                    });
                    event.preventDefault();
                    return;
                }

                const tableBody = document.getElementById("transaction-table-body");
                const menu = [];
                const qty = [];

                tableBody.querySelectorAll('tr').forEach(row => {
                    const menuName = row.children[0].textContent;
                    const quantity = parseInt(row.querySelector('.quantity').value, 10);
                    menu.push(menuName);
                    qty.push(quantity);
                });

                document.getElementById('jml_total_input').value = parseFloat(document.getElementById(
                    "jml_total").innerText.replace("Rp ", "").replace(/\./g, "").replace(",", "."));
                document.getElementById('jml_bayar_input').value = parseFloat(document.getElementById(
                    "modal-jml_bayar").value.replace("Rp ", "").replace(/\./g, ""));
                document.getElementById('jml_kembali_input').value = parseFloat(document.getElementById(
                    "modal-jml_kembali").textContent.replace("Rp ", "").replace(/\./g, "").replace(
                    ",",
                    "."));
                document.getElementById('menu_input').value = JSON.stringify(menu);
                document.getElementById('qty_input').value = JSON.stringify(qty);

                // Ambil nilai nm_metode_pembayaran dan set ke hidden input
                const nm_metode_pembayaran = document.getElementById('kd_metode').value;
                document.getElementById('kd_metode_input').value = nm_metode_pembayaran;

                form.submit();
            });
        });

        function submitTransaction() {
            const tableBody = document.getElementById("transaction-table-body");
            const modalTableBody = document.getElementById("modal-transaction-table-body");
            modalTableBody.innerHTML = '';

            let total = 0;

            tableBody.querySelectorAll('tr').forEach(row => {
                const menuName = row.children[0].textContent;
                const quantity = parseInt(row.querySelector('.quantity').value, 10);
                const pricePerUnit = row.children[2].textContent;
                const totalPrice = row.querySelector('.total-price').textContent;

                total += parseFloat(totalPrice.replace("Rp ", "").replace(/\./g, "").replace(",", "."));

                const newRow = document.createElement("tr");
                newRow.innerHTML = `
        <td>${menuName}</td>
        <td>${quantity}</td>
        <td>${pricePerUnit}</td>
        <td>${totalPrice}</td>
    `;
                modalTableBody.appendChild(newRow);
            });

            document.getElementById("modal-total-transaction").textContent = "Rp " + total.toLocaleString("id-ID");

            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();


        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: #ffffff;
            font-family: "Inter", sans-serif;
        }

        .card-title {
            font-weight: bold;
            color: #292828;
        }

        .table thead th {
            background-color: #a81005;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .form-group h4 {
            font-weight: bold;
        }

        .total-section {
            border-top: 2px solid #a81005;
            padding-top: 10px;
        }

        .btn-danger {
        background-color: #a81005; 
        border-color: #a81005; 
        }

        .btn-danger:hover {
            background-color: #c82333; 
            border-color: #bd2130; 
            color: #ffffff;
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
            background-color:#007bff00;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .table tbody tr:first-child>* {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
