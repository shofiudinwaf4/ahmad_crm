<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\pelangganModel;
use App\Models\produkModel;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getProfile = User::findOrFail(session('id'));
        $getProduk = produkModel::all();
        $data = [
            'aktif' => 'Produk',
            'title' => 'Produk',
            'profile' => $getProfile,
            'produk' => $getProduk,
        ];
        return \view('produk', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getProfile = User::findOrFail(session('id'));
        $data = [
            'aktif' => 'Produk',
            'title' => 'Tambah Produk',
            'profile' => $getProfile,
        ];
        return \view('addProduk', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'hpp' => 'required',
            'margin' => 'required',
        ], [
            'nama_produk.required' => 'Nama Produk wajib diisi!',
            'hpp.required' => 'HPP wajib diisi!',
            'margin.required' => 'Margin wajib diisi!',
        ]);

        $hpp = $request->hpp ? (int)preg_replace('/[^0-9]/', '', $request->hpp) : 0;
        $margin = $request->margin ? (int)preg_replace('/[^0-9]/', '', $request->margin) : 0;
        $harga_jual = $hpp + $margin;
        $data = [
            'nama_produk' => $request->nama_produk,
            'hpp' => $hpp,
            'margin' => $margin,
            'harga_jual' => $harga_jual
        ];
        produkModel::create($data);
        return \redirect()->to('produk')->with('success', 'Data Produk berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $getProfile = User::findOrFail(session('id'));
        $getProduk = produkModel::findOrFail($id);
        $data = [
            'aktif' => 'Edit Produk',
            'title' => 'Produk',
            'profile' => $getProfile,
            'produk' => $getProduk
        ];
        return \view('addProduk', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'hpp' => 'required',
            'margin' => 'required',
        ], [
            'nama_produk.required' => 'Nama Produk wajib diisi!',
            'hpp.required' => 'HPP wajib diisi!',
            'margin.required' => 'Margin wajib diisi!',
        ]);

        $getProduk = produkModel::findOrFail($id);
        $hpp = $request->hpp ? (int)preg_replace('/[^0-9]/', '', $request->hpp) : 0;
        $margin = $request->margin ? (int)preg_replace('/[^0-9]/', '', $request->margin) : 0;
        $harga_jual = $hpp + $margin;
        $data = [
            'nama_produk' => $request->nama_produk,
            'hpp' => $hpp,
            'margin' => $margin,
            'harga_jual' => $harga_jual
        ];
        $getProduk->update($data);
        return \redirect()->to('produk')->with('success', 'Data Produk berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        produkModel::destroy($id);
        return \redirect()->back()->with('delete', 'Data Produk berhasil dihapus!');
    }
}
