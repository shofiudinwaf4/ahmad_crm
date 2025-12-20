@extends('layout/layout')
@section('content')
    @if (@session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (@session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (@session('delete'))
        <div class="alert alert-danger alert-dismissible show fade">
            {{ session('delete') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/addProduk" type="button" class="btn btn-sm btn-outline-primary">Tambah Produk</a>
        </div>
    </div>
    <!-- Cards -->
    <div class="row">
        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>HPP</th>
                        <th>Margin</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($produk as $produks)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $produks->nama_produk }}</td>
                            <td> @uang($produks->hpp, 0, ',', '.') </td>
                            <td> @uang($produks->margin, 0, ',', '.') </td>
                            <td> @uang($produks->harga_jual, 0, ',', '.') </td>
                            <td> <a class="btn btn-sm btn-warning btn-edit-project btn-sm"
                                    href='/editProduk/{{ $produks->id }}'>
                                    Edit </a>
                                <form action="/deleteProduk/{{ $produks->id }}" method="POST"
                                    onsubmit="return confirm('Apakah yakin akan melakukan penghapusan data?')"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">
                                        Hapus </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </main>
    @endsection
