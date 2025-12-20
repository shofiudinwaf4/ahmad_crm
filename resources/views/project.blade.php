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
    @if (session('role') == 'Sales')
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/doneProject" type="button" class="btn btn-sm btn-outline-primary">Pencapaian Project</a>
            </div>
        </div>
    @endif
    @if (session('role') == 'Manager')
        <form method="GET" class="row mb-3">
            <div class="col-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="approved">Approved</option>
                    <option value="waiting approval">Waiting Approval</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="col-4">
                <button class="btn btn-primary">Filter</button>
                {{-- <a href="/reportLead" class="btn btn-secondary">Reset</a> --}}
            </div>

        </form>
    @endif
    <!-- Cards -->
    <div class="row">
        <!-- Tabel -->
        <div class="table-responsive">
            @if (session('role') == 'Sales')
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Kebutuhan</th>
                            <th>produk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;

                        @endphp
                        @foreach ($lead as $leads)
                            @php
                                $leadProjects = $project->where('id_lead', $leads->id);
                                $hasProject = $project->contains('id_lead', $leads->id);
                                $waitingApproval = $leadProjects->where('status', 'waiting approval')->count() > 0;
                                $reject = $leadProjects->where('status', 'rejected')->count() > 0;
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $leads->nama }}</td>
                                <td>{{ $leads->kontak }}</td>
                                <td>{{ $leads->alamat }}</td>
                                <td>{{ $leads->kebutuhan }}</td>
                                <td>
                                    @foreach ($project as $projects)
                                        @if ($projects->id_lead == $leads->id)
                                            {{ $projects->produk->nama_produk }}<br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($project as $projects)
                                        @if ($projects->id_lead == $leads->id)
                                            <span
                                                class="badge @if ($projects->status == 'waiting approval') text-bg-secondary
                                        @elseif ($projects->status == 'approved') text-bg-success
                                        @else text-bg-danger @endif">{{ $projects->status }}</span><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        @if (!$hasProject)
                                            <a class="btn btn-sm btn-primary" href='/addProdukProject/{{ $leads->id }}'>
                                                Tambah Produk </a>
                                        @endif
                                        @if ($reject)
                                            <a class="btn btn-sm btn-warning"
                                                href='/editProdukProject/{{ $leads->id }}'>
                                                Edit Produk </a>
                                        @endif
                                        @if (!$waitingApproval && !$reject)
                                            <a class="btn btn-sm btn-success" href='/bayar/{{ $leads->id }}'>
                                                Bayar </a>
                                        @endif
                                        {{-- <form action="/deleteProduk/{{ $leads->id }}" method="POST"
                                        onsubmit="return confirm('Apakah yakin akan melakukan penghapusan data?')"
                                        class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" name="submit" class="btn btn-sm btn-danger">
                                            Hapus </button>
                                    </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif (session('role') == 'Manager')
                <table class="table table-bordered order-2">
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
                                <td><button
                                        class="btn @if ($projects->status == 'approved') btn-success
                                            @elseif ($projects->status == 'rejected')
                                            btn-danger
                                        @else
                                            btn-secondary @endif btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#editApproval" data-id="{{ $projects->id }}"
                                        data-namaLead="{{ $projects->lead->nama . '-' . $projects->produk->nama_produk }}"
                                        data-status="{{ $projects->status }}">
                                        {{ $projects->status }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
        </main>
        <div class="modal fade" id="editApproval" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editApprovalForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Approval Project <span id="modalLeadNama"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" id="editApproval" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="waiting approval">Waiting Approval</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Reject</option>
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
            document.getElementById('editApproval').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget

                let id = button.getAttribute('data-id')
                let nama = button.getAttribute('data-namaLead')
                let status = button.getAttribute('data-status')

                document.getElementById('editApprovalForm').action = `/updateApprovalProject/${id}`
                document.getElementById('editApproval').value = status
                document.getElementById('modalLeadNama').innerText = nama
            })
        </script>
    @endpush
