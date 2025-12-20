@extends('layout/layout')
@section('content')
    @if (@session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <!-- Tabel -->
        <form action="{{ url('/changeCustomer', $lead->id) }}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="col-12">
                                <div class="row">
                                    <div class="mb-3">
                                        <input type="hidden" name="id_lead" value="{{ $lead->id }}">
                                        <label>Jenis Lead</label>
                                        <select name="jenis_lead" id="jenis_lead"
                                            class="form-select @error('jenis_lead') is-invalid @enderror">
                                            <option value="baru">Customer Baru</option>
                                            <option value="lama">Customer Lama</option>
                                        </select>
                                        @error('jenis_lead')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3" id="formNoCustomer" style="display: none;">
                                        <label for="addNoCustomer" class="form-label">No Customer</label>
                                        <input type="text"
                                            class="form-control @error('no_pelanggan') is-invalid @enderror"
                                            name="no_pelanggan" id="no_pelanggan">
                                        @error('no_pelanggan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <table>
                                <thead>
                                    <th colspan="2">Data Leads</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Nama</td>
                                        <td>: {{ $lead->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kontak</td>
                                        <td>: {{ $lead->kontak }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Alamat</td>
                                        <td>: {{ $lead->alamat }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <table class="table table-bordered order-2">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga Jual</th>
                                <th>Harga Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $total = 0;
                            @endphp
                            @foreach ($project as $projects)
                                @php

                                    $total += $projects->permintaan_harga;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $projects->produk->nama_produk }}</td>
                                    <td class="text-end">@uang($projects->harga_jual, 0, ',', '.') </td>
                                    <td class="text-end">@uang($projects->permintaan_harga, 0, ',', '.')</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-center text-bold" colspan="3">Total</td>
                                <td class="text-end">@uang($total, 0, ',', '.')</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success">Change Customer</button>
            </div>
        </form>
        </main>
    @endsection
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectJenisLead = document.getElementById('jenis_lead');
                const formNoCustomer = document.getElementById('formNoCustomer');

                selectJenisLead.addEventListener('change', function() {
                    if (this.value === 'lama') {
                        formNoCustomer.style.display = 'block';
                    } else {
                        formNoCustomer.style.display = 'none';
                        document.getElementById('no_customer').value = ''; // reset input
                    }
                });
            });
        </script>
    @endpush
