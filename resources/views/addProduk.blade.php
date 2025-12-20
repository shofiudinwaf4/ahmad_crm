@extends('layout/layout')
@section('content')
    <div class="row">
        <!-- Tabel -->
        <form class="row" action="{{ isset($produk) ? url('/updateProduk', $produk->id) : url('/storeProduk') }}"
            method="POST">
            @csrf
            @if (isset($produk))
                @method('PUT')
            @endif
            <div class="col-md-12">
                <label for="inputNama" class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                    placeholder="Masukkan Nama Produk"
                    value='{{ isset($produk['nama_produk']) ? $produk['nama_produk'] : old('nama_produk') }}'>
                @error('nama_produk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="inputHpp" class="form-label">HPP</label>
                <div class="input-group mb-3">
                    <input type="text" id="hpp" name="hpp"
                        class="form-control @error('hpp') is-invalid @enderror" placeholder="Rp. 0"
                        onkeyup="formatCurrency(this); hitungHargaJual()" onkeypress="return hanyaAngka(event)"
                        value="{{ isset($produk['hpp']) ? $produk['hpp'] : old('hpp') }}">
                    @error('hpp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputMargin" class="form-label">Margin</label>
                <div class="input-group mb-3">
                    <input type="text" id="margin" name="margin"
                        class="form-control @error('margin') is-invalid @enderror" placeholder="Rp. 0"
                        onkeyup="formatCurrency(this); hitungHargaJual()" onkeypress="return hanyaAngka(event)"
                        value="{{ isset($produk['margin']) ? $produk['margin'] : old('margin') }}">

                    @error('margin')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="hargaJual" class="form-label">Harga Jual</label>
                <div class="input-group mb-3">
                    <input type="text" id="harga_jual" name="harga_jual"
                        class="form-control @error('harga_jual') is-invalid @enderror" placeholder="Rp. 0"
                        value="{{ isset($produk['harga_jual']) ? $produk['harga_jual'] : old('harga_jual') }}" readonly>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
        </main>
    @endsection
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const hpp = document.getElementById('hpp');
                const margin = document.getElementById('margin');

                if (hpp?.value) formatCurrency(hpp);
                if (margin?.value) formatCurrency(margin);

                hitungHargaJual();
            });
        </script>
    @endpush
