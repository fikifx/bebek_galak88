<div class="actions-data">
    <button class="more-btn ml-10 dropdown-toggle" id="moreAction{{ $row->id }}" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="lni lni-more-alt"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction{{ $row->id }}">
        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalHapusTransaksi{{ $row->id }}"
                class="dropdown-item text-gray">Hapus</a></li>
        <li><a href="{{ route('invoice.show', $row->kd_transaksi) }}" target="_blank" class="dropdown-item">Invoice</a>
        </li>
    </ul>
</div>
