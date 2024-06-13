<ul>
    <li class="nav-item @if (request()->routeIs('home')) active @endif">
        <a href="{{ route('home') }}">
            <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22">
                    <path
                        d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                </svg>
            </span>
            <span class="text">{{ __('Dashboard') }}</span>
        </a>
    </li>

    @if (auth()->user()->hasRole('super-admin'))
        <li class="nav-item @if (request()->routeIs('from.index')) active @endif">
            <a href="{{ route('from.index') }}">
                <span class="icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.8097 1.66667C11.8315 1.66667 11.8533 1.6671 11.875 1.66796V4.16667C11.875 5.43232 12.901 6.45834 14.1667 6.45834H16.6654C16.6663 6.48007 16.6667 6.50186 16.6667 6.5237V16.6667C16.6667 17.5872 15.9205 18.3333 15 18.3333H5.00001C4.07954 18.3333 3.33334 17.5872 3.33334 16.6667V3.33334C3.33334 2.41286 4.07954 1.66667 5.00001 1.66667H11.8097ZM6.66668 7.70834C6.3215 7.70834 6.04168 7.98816 6.04168 8.33334C6.04168 8.67851 6.3215 8.95834 6.66668 8.95834H10C10.3452 8.95834 10.625 8.67851 10.625 8.33334C10.625 7.98816 10.3452 7.70834 10 7.70834H6.66668ZM6.04168 11.6667C6.04168 12.0118 6.3215 12.2917 6.66668 12.2917H13.3333C13.6785 12.2917 13.9583 12.0118 13.9583 11.6667C13.9583 11.3215 13.6785 11.0417 13.3333 11.0417H6.66668C6.3215 11.0417 6.04168 11.3215 6.04168 11.6667ZM6.66668 14.375C6.3215 14.375 6.04168 14.6548 6.04168 15C6.04168 15.3452 6.3215 15.625 6.66668 15.625H13.3333C13.6785 15.625 13.9583 15.3452 13.9583 15C13.9583 14.6548 13.6785 14.375 13.3333 14.375H6.66668Z" />
                        <path
                            d="M13.125 2.29167L16.0417 5.20834H14.1667C13.5913 5.20834 13.125 4.74197 13.125 4.16667V2.29167Z" />
                    </svg>
                </span>
                <span class="text">{{ __('From Menu') }}</span>
            </a>
        </li>
    @endif



    <li class="nav-item nav-item-has-children">
        <a class="collapsed" href="#0" class="" data-bs-toggle="collapse" data-bs-target="#menu_1"
            aria-controls="menu_1" aria-expanded="true" aria-label="Toggle navigation">
            <span class="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3.33334 3.35442C3.33334 2.4223 4.07954 1.66666 5.00001 1.66666H15C15.9205 1.66666 16.6667 2.4223 16.6667 3.35442V16.8565C16.6667 17.5519 15.8827 17.9489 15.3333 17.5317L13.8333 16.3924C13.537 16.1673 13.1297 16.1673 12.8333 16.3924L10.5 18.1646C10.2037 18.3896 9.79634 18.3896 9.50001 18.1646L7.16668 16.3924C6.87038 16.1673 6.46298 16.1673 6.16668 16.3924L4.66668 17.5317C4.11731 17.9489 3.33334 17.5519 3.33334 16.8565V3.35442ZM4.79168 5.04218C4.79168 5.39173 5.0715 5.6751 5.41668 5.6751H10C10.3452 5.6751 10.625 5.39173 10.625 5.04218C10.625 4.69264 10.3452 4.40927 10 4.40927H5.41668C5.0715 4.40927 4.79168 4.69264 4.79168 5.04218ZM5.41668 7.7848C5.0715 7.7848 4.79168 8.06817 4.79168 8.41774C4.79168 8.76724 5.0715 9.05066 5.41668 9.05066H10C10.3452 9.05066 10.625 8.76724 10.625 8.41774C10.625 8.06817 10.3452 7.7848 10 7.7848H5.41668ZM4.79168 11.7932C4.79168 12.1428 5.0715 12.4262 5.41668 12.4262H10C10.3452 12.4262 10.625 12.1428 10.625 11.7932C10.625 11.4437 10.3452 11.1603 10 11.1603H5.41668C5.0715 11.1603 4.79168 11.4437 4.79168 11.7932ZM13.3333 4.40927C12.9882 4.40927 12.7083 4.69264 12.7083 5.04218C12.7083 5.39173 12.9882 5.6751 13.3333 5.6751H14.5833C14.9285 5.6751 15.2083 5.39173 15.2083 5.04218C15.2083 4.69264 14.9285 4.40927 14.5833 4.40927H13.3333ZM12.7083 8.41774C12.7083 8.76724 12.9882 9.05066 13.3333 9.05066H14.5833C14.9285 9.05066 15.2083 8.76724 15.2083 8.41774C15.2083 8.06817 14.9285 7.7848 14.5833 7.7848H13.3333C12.9882 7.7848 12.7083 8.06817 12.7083 8.41774ZM13.3333 11.1603C12.9882 11.1603 12.7083 11.4437 12.7083 11.7932C12.7083 12.1428 12.9882 12.4262 13.3333 12.4262H14.5833C14.9285 12.4262 15.2083 12.1428 15.2083 11.7932C15.2083 11.4437 14.9285 11.1603 14.5833 11.1603H13.3333Z">
                    </path>

                </svg>
            </span>
            <span class="text">Pengeluaran</span>
        </a>
        <ul id="menu_1" class="dropdown-nav collapse" style="">
            @if (auth()->user()->hasRole('super-admin'))
                <li>
                    <a href="{{ route('pengeluaran.index') }}">Kategori Pengeluaran</a>
                </li>
            @endif

            <li>
                <a href="{{ route('laporan-pengeluaran.index') }}">Laporan Pengeluaran</a>
            </li>

        </ul>
    </li>



    <li class="nav-item @if (request()->routeIs('kasir')) active @endif">
        <a href="{{ route('kasir.index') }}" target="_blank">
            <span class="icon">
                <svg width="22" height="22" aria-hidden="true" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                    </path>
                </svg>
            </span>
            <span class="text">{{ __('kasir') }}</span>
        </a>
    </li>

    @if (auth()->user()->hasRole('super-admin'))
        <li class="nav-item @if (request()->routeIs('users.index')) active @endif">
            <a href="{{ route('users.index') }}">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </span>
                <span class="text">{{ __('Users') }}</span>
            </a>
        </li>

        <li class="nav-item @if (request()->routeIs('pembayaran.index')) active @endif">
            <a href="{{ route('pembayaran.index') }}">
                <span class="icon">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.16669 1.35417C2.61541 1.35417 2.97919 1.71794 2.97919 2.16667V21.6667C2.97919 22.4146 3.58546 23.0208 4.33335 23.0208H23.8334C24.2821 23.0208 24.6459 23.3846 24.6459 23.8333C24.6459 24.2821 24.2821 24.6458 23.8334 24.6458H4.33335C2.68801 24.6458 1.35419 23.312 1.35419 21.6667V2.16667C1.35419 1.71794 1.71796 1.35417 2.16669 1.35417Z" fill="currentColor"></path>
                        <path d="M5.41669 6.5C5.41669 5.9017 5.90172 5.41667 6.50002 5.41667H10.8334C11.4317 5.41667 11.9167 5.9017 11.9167 6.5V19.5C11.9167 20.0983 11.4317 20.5833 10.8334 20.5833H6.50002C5.90172 20.5833 5.41669 20.0983 5.41669 19.5V6.5Z" fill="currentColor"></path>
                        <path d="M15.1666 10.8333C14.5683 10.8333 14.0833 11.3183 14.0833 11.9167V19.5C14.0833 20.0983 14.5683 20.5833 15.1666 20.5833H19.5C20.0983 20.5833 20.5833 20.0983 20.5833 19.5V11.9167C20.5833 11.3183 20.0983 10.8333 19.5 10.8333H15.1666Z" fill="currentColor"></path>
                      </svg>
                </span>
                <span class="text">Metode Pembayaran</span>
            </a>
        </li>


        <li class="nav-item nav-item-has-children">
            <a class="collapsed" href="#0" class="" data-bs-toggle="collapse" data-bs-target="#ddmenu_1"
                aria-controls="ddmenu_1" aria-expanded="true" aria-label="Toggle navigation">
                <span class="icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.8334 1.83325H5.50008C5.01385 1.83325 4.54754 2.02641 4.20372 2.37022C3.8599 2.71404 3.66675 3.18036 3.66675 3.66659V18.3333C3.66675 18.8195 3.8599 19.2858 4.20372 19.6296C4.54754 19.9734 5.01385 20.1666 5.50008 20.1666H16.5001C16.9863 20.1666 17.4526 19.9734 17.7964 19.6296C18.1403 19.2858 18.3334 18.8195 18.3334 18.3333V7.33325L12.8334 1.83325ZM16.5001 18.3333H5.50008V3.66659H11.9167V8.24992H16.5001V18.3333Z">
                        </path>
                    </svg>
                </span>
                <span class="text">Transaksi</span>
            </a>
            <ul id="ddmenu_1" class="dropdown-nav collapse" style="">
                <li>
                    <a href="{{ route('transaksi.index') }}">Laporan Transaksi</a>
                </li>
            </ul>
            <ul id="ddmenu_1" class="dropdown-nav collapse" style="">
                <li>
                    <a href="{{ route('detail-transaksi.index') }}">Laporan Transaksi PerMenu</a>
                </li>
            </ul>
        </li>
    @endif


</ul>
