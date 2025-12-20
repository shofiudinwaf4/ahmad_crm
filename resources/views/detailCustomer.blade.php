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
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table>
                            <thead>
                                <th colspan="2">Detai Customer <span
                                        class="badge text-bg-{{ $customer->is_active == 'aktif' ? 'success' : 'danger' }}">{{ $customer->is_active }}</span>
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        No Pelanggan</td>
                                    <td>: {{ $customer->no_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        Nama</td>
                                    <td>: {{ $customer->nama }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        Kontak</td>
                                    <td>: {{ $customer->kontak }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        Alamat</td>
                                    <td>: {{ $customer->alamat }}</td>
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
                            <th>No Langganan</th>
                            <th>Nama Layanan</th>
                            <th>Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($customer->layanan as $layanan)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $layanan->no_langganan }}</td>
                                <td>{{ $layanan->nama_layanan }}</td>
                                <td class="text-end">@uang($layanan->tagihan, 0, ',', '.') </td>
                                @if (session('role') == 'Manager')
                                    <td><button
                                            class="btn 
                                btn-{{ $layanan->is_active == 'aktif' ? 'success' : 'danger' }} btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#editActiveModal"
                                            data-id="{{ $layanan->id }}" data-namaLayanan="{{ $layanan->nama_layanan }}"
                                            data-is_active="{{ $layanan->is_active }}">
                                            {{ $layanan->is_active }}
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="editActiveModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editActiveForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Aktif Layanan <span id="modalNamaLayanan"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label> Status Aktif</label>
                                <select name="is_active" id="editIsActive" class="form-select" required>
                                    <option value="">-- Pilih Status Aktif --</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </main>
    @endsection
    @push('scripts')
        <script>
            document.getElementById('editActiveModal').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget

                let id = button.getAttribute('data-id')
                let nama = button.getAttribute('data-namaLayanan')
                let isActive = button.getAttribute('data-is_active')

                document.getElementById('editActiveForm').action = `/updateIsActiveLayanan/${id}`
                document.getElementById('editIsActive').value = isActive
                document.getElementById('modalNamaLayanan').innerText = nama
            })
        </script>
    @endpush
