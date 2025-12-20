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
    <!-- Cards -->
    <div class="row">
        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Nama Lead</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Harga Deal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp

                    @foreach ($project as $projects)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $projects->produk->nama_produk }}</td>
                            <td>{{ $projects->lead->nama }}</td>
                            <td>{{ $projects->lead->kontak }}</td>
                            <td>{{ $projects->lead->alamat }}</td>
                            <td>@uang($projects->permintaan_harga, 0, ',', '.')</td>
                            <td><span class="badge text-bg-success">{{ $projects->status_project }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </main>
    @endsection
