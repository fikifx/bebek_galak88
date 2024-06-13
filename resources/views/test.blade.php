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
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="card-style p-3 mb-3" style="background-color: #ffffff;">
                    <h5 class="card-title">{{ $kategori }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($items as $barang)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-nama="{{ $barang->nm_barang }}"
                                data-harga="{{ number_format($barang->hrg_barang, 2, ',', '.') }}"
                                onclick="addToTransaction('{{ $barang->nm_barang }}', '{{ number_format($barang->hrg_barang, 2, ',', '.') }}')">
                                {{ $barang->nm_barang }}
                                <span class="badge bg-primary">Rp
                                    {{ number_format($barang->hrg_barang, 2, ',', '.') }}</span>
                                <span class="badge bg-secondary">{{ $barang->stoks->sum('jml_stok') }}</span>
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

                    <button class="btn btn-primary btn-lg" onclick="submitTransaction()">Konfirmasi</button>
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
    </form>

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            placeholder="Rp ">
                    </div>
                    <div class="form-group">
                        <label for="modal-jml_kembali">Total Kembalian</label>
                        <div class="form-group">
                            <h4 id="modal-jml_kembali" class="text-danger">Rp 0</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmTransactionButton">Konfirmasi &
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                        submitTransaction();
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
        <td style="width: 60px;">
            <input type="number" class="form-control quantity" value="1" onchange="calculateSubtotal(this)" style="border: none;">
        </td>
        <td class="harga-per-unit">Rp ${hargaPerUnit}</td>
        <td> <span class="total-price">${hargaPerUnit}</span></td>
        <td><button class="btn btn-danger btn-sm" onclick="removeFromTransaction(this)"><i class="fas fa-times"></i></button></td>
    `;

            newRow.querySelector('.quantity').setAttribute('data-harga-per-unit', hargaPerUnit);

            tableBody.appendChild(newRow);
            calculateTotal();
        }

        function removeFromTransaction(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateTotal();
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
