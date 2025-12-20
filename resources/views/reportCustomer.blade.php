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
            <select name="is_active" class="form-select">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
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
                        <th>No Pelanggan</th>
                        <th>Nama Customer</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($customer as $customers)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $customers->no_pelanggan }}</td>
                            <td>{{ $customers->nama }}</td>
                            <td>{{ $customers->kontak }}</td>
                            <td>{{ $customers->alamat }}</td>
                            <td class="text-center">
                                <span
                                    class="badge text-bg-{{ $customers->is_active == 'aktif' ? 'success' : 'secondary' }}">
                                    {{ $customers->is_active }}</span>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="GET" action="/report/customer/export" target="_blank">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <input type="hidden" name="status" value="{{ request('is_active') }}">

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
