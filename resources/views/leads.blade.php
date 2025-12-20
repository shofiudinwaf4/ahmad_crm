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
            <a href="/addLeads" type="button" class="btn btn-sm btn-outline-primary">Tambah Leads</a>
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
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Kebutuhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                            <td>{{ $leads->kebutuhan }}</td>
                            <td><button
                                    class="btn 
                                @if ($leads->status == 'baru') btn-warning
                                @elseif ($leads->status == 'proses') btn-secondary
                                @elseif ($leads->status == 'deal') btn-success
                                @elseif ($leads->status == 'gagal') btn-danger @endif btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#editStatusModal" data-id="{{ $leads->id }}"
                                    data-nama="{{ $leads->nama }}" data-status="{{ $leads->status }}">
                                    {{ $leads->status }}
                                </button></td>
                            <td> <a class="btn btn-sm btn-warning btn-edit-project btn-sm"
                                    href='/editLeads/{{ $leads->id }}'>
                                    Edit </a>
                                <form action="/deleteLeads/{{ $leads->id }}" method="POST"
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
        <div class="modal fade" id="editStatusModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editStatusForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Status Lead <span id="modalLeadNama"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" id="editStatus" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="baru">Baru</option>
                                    <option value="proses">Proses</option>
                                    <option value="deal">Deal</option>
                                    <option value="gagal">Gagal</option>
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
    @endsection
    @push('scripts')
        <script>
            document.getElementById('editStatusModal').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget

                let id = button.getAttribute('data-id')
                let nama = button.getAttribute('data-nama')
                let status = button.getAttribute('data-status')

                document.getElementById('editStatusForm').action = `/updateStatusLeads/${id}`
                document.getElementById('editStatus').value = status
                document.getElementById('modalLeadNama').innerText = nama
            })
        </script>
    @endpush
