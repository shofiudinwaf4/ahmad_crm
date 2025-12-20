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
    <form method="GET" class="row mb-3">

        <div class="col-3">
            <div class="input-group mb-3">
                <input type="text" id="rangeDate" name="tanggal" class="form-control"
                    placeholder="Pilih rentang tanggal">
            </div>
        </div>

        <div class="col-3">
            <select name="id_user" class="form-select">
                <option value="">Semua Sales</option>
                @foreach ($sales as $user)
                    <option value="{{ $user->id }}" {{ request('id_user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <div class="col-3">
            <button class="btn btn-primary">Filter</button>
            {{-- <a href="/reportLead" class="btn btn-secondary">Reset</a> --}}
        </div>

    </form>

    <!-- Cards -->

    <div class="row">
        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Lead</th>
                        <th>Nama Produk</th>
                        <th>Nama Sales</th>
                        <th>Harga Jual</th>
                        <th>Harga Pengajuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($project as $projects)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $projects->lead->nama }}</td>
                            <td>{{ $projects->produk->nama_produk }}</td>
                            <td>{{ $projects->sales->name }}</td>
                            <td class="text-end">@uang($projects->harga_jual, 0, ',', '.') </td>
                            <td class="text-end">@uang($projects->permintaan_harga, 0, ',', '.') </td>
                            <td class="text-center">
                                <span
                                    class="badge text-bg-{{ $projects->status_project == 'selesai' ? 'success' : 'secondary' }}">
                                    {{ $projects->status_project }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="GET" action="/report/project/export" target="_blank">
                <input type="hidden" name="id_user" value="{{ request('id_user') }}">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">

                <button class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Download Excel
                </button>
            </form>
        </div>
        </main>
    @endsection
    @push('scripts')
        <script>
            flatpickr("#rangeDate", {
                mode: "range",
                dateFormat: "Y-m-d",
                allowInput: true,
                locale: "id"
            });
        </script>
    @endpush
