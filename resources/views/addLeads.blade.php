@extends('layout/layout')
@section('content')
    <div class="row">
        <!-- Tabel -->
        <form class="row" action="{{ isset($lead) ? url('/updateLeads', $lead->id) : url('/storeLeads') }}" method="POST">
            @csrf
            @if (isset($lead))
                @method('PUT')
            @endif
            <div class="col-md-6">
                <label for="inputNama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Masukkan Nama" value='{{ isset($lead['nama']) ? $lead['nama'] : old('nama') }}'>
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputKontak" class="form-label">Kontak</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">+62</span>
                    <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror"
                        placeholder="86******" value='{{ isset($lead['kontak']) ? $lead['kontak'] : old('kontak') }}'>
                    @error('kontak')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                    id="inputAddress" placeholder="1234 Main St"
                    value='{{ isset($lead['alamat']) ? $lead['alamat'] : old('alamat') }}'>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Kebutuhan</label>
                <textarea class="form-control @error('kebutuhan') is-invalid @enderror" name="kebutuhan"
                    id="exampleFormControlTextarea1" rows="3">{{ isset($lead['kebutuhan']) ? $lead['kebutuhan'] : old('kebutuhan') }}
                </textarea>
                @error('kebutuhan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
        </main>
    @endsection
