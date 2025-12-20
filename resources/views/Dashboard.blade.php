@extends('layout/layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Laporan Leads</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Baru</h5>
                            <p class="card-text">{{ $leadBaru }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-secondary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Proses</h5>
                            <p class="card-text">{{ $leadProses }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Deal</h5>
                            <p class="card-text">{{ $leadDeal }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>Laporan Project</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Proses</h5>
                                    <p class="card-text">{{ $projectProses }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-white bg-secondary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Selesai</h5>
                                    <p class="card-text">{{ $projectSelesai }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>Laporan Approval Harga Project</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Approved</h5>
                                    <p class="card-text">{{ $projectApproved }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-secondary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Waiting Approval</h5>
                                    <p class="card-text">{{ $projectWaiting }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Rejected</h5>
                                    <p class="card-text">{{ $projectRejected }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabel -->
    <div class="card mb-3">
        <div class="card-header">
            <h4>Data Lead Terbaru</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($getLeadTerbaru as $leadTerbaru)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $leadTerbaru->nama }}</td>
                                <td>{{ $leadTerbaru->kontak }}</td>
                                <td>{{ $leadTerbaru->alamat }}</td>
                                <td>{{ $leadTerbaru->status }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </main>
@endsection
