@extends('layouts.appNew')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap">
                    <h2 class="mr-40">User</h2>
                    <a href="#0" class="main-btn primary-btn btn-hover btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="lni lni-plus mr-5"></i> Tambah User</a>

                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">

                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>


    {{-- Modal --}}

    <!-- Modal Create -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-style mb-30">
                                <form class="row needs-validation" novalidate="" action="{{ route('users.store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label for="f-name" class="form-label">
                                                Nama
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Masukkan nama" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label for="email" class="form-label"> Email </label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Masukkan email" required="">
                                            <div class="invalid-feedback">
                                                Please Enter a valid Email.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="select-style-1">
                                            <label for="f-name" class="form-label">
                                                Role
                                            </label>
                                            <div class="select-position">
                                                <select class="form-control" id="akses" name="akses">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-style-1">
                                            <label for="city" class="form-label"> Password </label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                id="city" placeholder="password" required="">
                                            <div class="invalid-feedback">
                                                Invalid password !
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-style-1">
                                            <label for="zip" class="form-label"> Confirm Password </label>
                                            <input type="password" class="form-control" id="zip"
                                                placeholder="Confirm Password" required="">
                                            <div class="invalid-feedback">
                                                Invalid password !
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button type="submit" class="main-btn w-100 primary-btn btn-hover m-2">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>

                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-4">
                            <div class="card-style mb-30 text-center">
                                <h6 class="mb-15">Masukkan Gambar</h6>
                                <p class="text-sm mb-25">
                                    Start creating the best possible user experience for you
                                    customers.
                                </p>
                                <div class="mx-auto text-center">

                                    <img src="{{ asset('images/logo/user-defult.png') }}" class="rounded-circle"
                                        width="100px" height="100px" alt="Avatar">


                                </div>
                                <div class="text-center mt-10">
                                    <a href="#0" class="main-btn btn-sm light-btn btn-hover">
                                        <i class="lni lni-upload"></i>
                                        Upload
                                    </a>
                                </div>


                            </div>
                            <!-- end card -->
                        </div>
                        </form>
                        <!-- end col -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- End Modal --}}

    {{-- Modal update --}}
    @foreach ($users as $user)
        <div class="modal fade" id="exampleModalupdate-{{ $user->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Update User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card-style mb-30">


                                    <form class="row needs-validation" novalidate=""
                                        action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="f-name" class="form-label">
                                                    Nama
                                                </label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Masukkan nama" value="{{ $user->name }}"
                                                    required="">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="email" class="form-label"> Email </label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Masukkan email" value="{{ $user->email }}"
                                                    required="">
                                                <div class="invalid-feedback">
                                                    Please Enter a valid Email.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="select-style-1">
                                                <label for="f-name" class="form-label">
                                                    Role
                                                </label>
                                                <div class="select-position">
                                                    <select class="form-control" id="akses" name="akses">
                                                        @foreach ($roles as $item)
                                                            <option value="{{ $item->name }}"
                                                                {{ $user->hasRole($item->name) ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>


                                                </div>
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button type="submit" class="main-btn w-100 primary-btn btn-hover m-2">
                                                    Perbarui
                                                </button>
                                            </div>
                                        </div>

                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-lg-4">
                                <div class="card-style mb-30 text-center">
                                    <h6 class="mb-15">Masukkan Gambar</h6>
                                    <p class="text-sm mb-25">
                                        Start creating the best possible user experience for you
                                        customers.
                                    </p>
                                    <div class="mx-auto text-center">

                                        <img src="{{ asset('images/logo/user-defult.png') }}" class="rounded-circle"
                                            width="100px" height="100px" alt="Avatar">


                                    </div>
                                    <div class="text-center mt-10">
                                        <a href="#0" class="main-btn btn-sm light-btn btn-hover">
                                            <i class="lni lni-upload"></i>
                                            Upload
                                        </a>
                                    </div>


                                </div>
                                <!-- end card -->
                            </div>
                            </form>
                            <!-- end col -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal --}}


    {{-- Modal Delete Confirmasi --}}
    @foreach ($users as $user)
        <div class="modal fade" id="exampleModalDelete{{ $user->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu ingin Menghapus User {{ $user->name }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <!-- Menggunakan metode DELETE -->
                            <button type="submit" class="btn btn-sm btn-danger">
                                <!-- Menggunakan tombol submit -->
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal --}}



    <!-- ========== title-wrapper end ========== -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-style clients-table-card mb-30">
                <div class="table-wrapper table-responsive">
                    <div class=""></div>
                    <table class="table clients-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>#</h6>
                                </th>
                                <th>
                                    <h6>Name</h6>
                                </th>
                                <th>
                                    <h6>Email</h6>
                                </th>
                                <th>
                                    <h6>Role</h6>
                                </th>
                                <th>
                                    <h6>Status</h6>
                                </th>
                                <th>
                                    <h6>Action</h6>
                                </th>
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>
                                        <div class="employee-image">
                                            <img src="{{ asset('images/logo/user-defult.png') }}" width="50%"
                                                alt="">
                                        </div>
                                    </td>
                                    <td class="min-width">
                                        <p>{{ $item->name }}</p>
                                    </td>
                                    <td class="min-width">
                                        <p><a href="#0">{{ $item->email }}</a></p>
                                    </td>
                                    <td class="min-width">
                                        <p><a href="#0">{{ $item->akses }}</a></p>
                                    </td>
                                    <td>
                                        <span class="status-btn active-btn">Active</span>
                                    </td>
                                    <td>
                                        <div class="action">
                                            <button class="text-primary">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalupdate-{{ $item->id }}"><i
                                                        class="lni lni-pencil-alt"></i></a>
                                            </button>
                                            <button class="btn btn-danger text-danger" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalDelete{{ $item->id }}">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                {{-- End Modal --}}
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
        <!-- end card -->
    </div>


    <!-- end col -->
    </div>
@endsection
