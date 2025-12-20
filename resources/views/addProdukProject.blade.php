@extends('layout/layout')
@section('content')
    <div class="row">
        <!-- Tabel -->
        {{-- <form method="POST" action="/storeProdukProject/{{ $lead->id }}"> --}}
        <form method="POST"
            action="{{ $isEdit ? url('/updateProdukProject/' . $lead->id) : url('/storeProdukProject/' . $lead->id) }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif
            <div class="card mb-3">
                <div class="card-body">
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

            <table class="table" id="produkTable">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Jual</th>
                        <th>Permintaan Harga</th>
                        <th>Approval</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($isEdit)
                        @foreach ($project as $i => $row)
                            <tr class="item-row">
                                <td>
                                    <select name="items[{{ $i }}][id_produk]" class="form-select produk">
                                        <option value="">-- Pilih produk --</option>
                                        @foreach ($produk as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_jual }}"
                                                {{ $row->id_produk == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $i }}][harga_jual]"
                                        class="form-control harga"
                                        value="{{ number_format($row->harga_jual, 0, ',', '.') }}" placeholder="Rp. 0"
                                        onkeyup="formatCurrency(this);" onkeypress="return hanyaAngka(event)" readonly>
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $i }}][permintaan_harga]"
                                        class="form-control permintaan"
                                        value="{{ number_format($row->permintaan_harga, 0, ',', '.') }}"
                                        placeholder="Rp. 0" onkeyup="formatCurrency(this);"
                                        onkeypress="return hanyaAngka(event)">
                                </td>
                                <td>
                                    <input type="text"
                                        class="form-control approval {{ $row->persetujuan == 'waiting approval' ? 'text-warning' : 'text-success' }}"
                                        value="{{ $row->persetujuan }}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm removeRow">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- MODE ADD --}}
                        <tr class="item-row">
                            <td>
                                <select name="items[0][id_produk]" class="form-select produk">
                                    <option value="">-- Pilih produk --</option>
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}" data-harga="{{ $p->harga_jual }}">
                                            {{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="items[0][harga_jual]" class="form-control harga"
                                    placeholder="Rp. 0" onkeyup="formatCurrency(this);"
                                    onkeypress="return hanyaAngka(event)" readonly>
                            </td>
                            <td>
                                <input type="text" name="items[0][permintaan_harga]" class="form-control permintaan"
                                    placeholder="Rp. 0" onkeyup="formatCurrency(this);"
                                    onkeypress="return hanyaAngka(event)">
                            </td>
                            <td>
                                <input type="text" class="form-control approval" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <button type="button" class="btn btn-secondary mt-2" id="addRow">
                + Tambah Produk
            </button>

            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
        </form>

        </main>
    @endsection
    @push('scripts')
        <script>
            let index = {{ $isEdit ? $project->count() : 1 }};

            document.getElementById('addRow').addEventListener('click', function() {

                const tbody = document.querySelector('#produkTable tbody');
                const firstRow = tbody.querySelector('.item-row');

                const newRow = firstRow.cloneNode(true);

                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                });

                newRow.querySelectorAll('select, input').forEach(el => {
                    if (el.name) {
                        el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
                    }
                });

                tbody.appendChild(newRow);
                index++;
            });
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.item-row').forEach(row => {
                    hitungApproval(row);
                });
            });
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                    }
                }
            });
            document.addEventListener('input', function(e) {

                if (e.target.classList.contains('produk')) {
                    let harga = e.target.selectedOptions[0].dataset.harga;
                    let row = e.target.closest('tr');
                    row.querySelector('.harga').value = harga;
                    hitungApproval(row);
                }

                if (e.target.classList.contains('permintaan')) {
                    let row = e.target.closest('tr');
                    hitungApproval(row);
                }
            });

            function hitungApproval(row) {
                let harga = parseInt(row.querySelector('.harga').value.replace(/\D/g, '')) || 0;
                let permintaan = parseInt(row.querySelector('.permintaan').value.replace(/\D/g, '')) || 0;

                let approval = row.querySelector('.approval');

                if (permintaan > 0 && harga > permintaan) {
                    approval.value = 'waiting approval';
                    approval.className = 'form-control approval text-warning';
                } else {
                    approval.value = 'approved';
                    approval.className = 'form-control approval text-success';
                }
            }
        </script>
    @endpush
