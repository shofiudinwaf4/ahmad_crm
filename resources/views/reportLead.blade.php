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

        <div class="col-4">
            <div class="input-group mb-3">
                <input type="text" id="rangeDate" name="tanggal" class="form-control"
                    placeholder="Pilih rentang tanggal">
            </div>
        </div>

        <div class="col-4">
            <select name="id_user" class="form-select">
                <option value="">Semua Sales</option>
                @foreach ($sales as $user)
                    <option value="{{ $user->id }}" {{ request('id_user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-4">
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
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Sales</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($lead as $leads)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $leads->nama }}</td>
                            <td>{{ $leads->kontak }}</td>
                            <td>{{ $leads->alamat }}</td>
                            <td>{{ $leads->sales->name }}</td>
                            <td>{{ date('d/m/Y', strtotime($leads->created_at)) }}</td>
                            <td><span
                                    class="badge @if ($leads->status == 'baru') text-bg-warning
                                @elseif ($leads->status == 'proses') text-bg-secondary
                                @elseif ($leads->status == 'deal') text-bg-success
                                @elseif ($leads->status == 'gagal') text-bg-danger @endif">{{ $leads->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="GET" action="/report/lead/export" target="_blank">
                <input type="hidden" name="id_user" value="{{ request('id_user') }}">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">

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
