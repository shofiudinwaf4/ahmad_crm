<?php

namespace App\Http\Controllers;

use App\Models\leadsModel;
use App\Models\pelangganModel;
use App\Models\User;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getProfile = User::findOrFail(session('id'));
        $getLeads = leadsModel::where('id_user', session('id'))->whereNotIn('status', ['deal', 'done'])->get();
        $data = [
            'aktif' => 'Leads',
            'title' => 'Leads',
            'profile' => $getProfile,
            'lead' => $getLeads,
        ];
        return \view('leads', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getProfile = User::findOrFail(session('id'));
        $data = [
            'aktif' => 'Leads',
            'title' => 'Tambah Leads',
            'profile' => $getProfile,
        ];
        return \view('addLeads', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
            'kebutuhan' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi!',
            'kontak.required' => 'Kontak wajib diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'kebutuhan.required' => 'Kebutuhan wajib dipilih!',
        ]);

        $data = [
            'id_user' => session('id'),
            'nama' => $request->nama,
            'kontak' => '+62' . $request->kontak,
            'alamat' => $request->alamat,
            'kebutuhan' => $request->kebutuhan,
            'status' => 'baru'
        ];
        leadsModel::create($data);

        return \redirect()->to('leads')->with('success', 'Data Leads berhasil ditambah!');
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
        $getLead = leadsModel::where('id_user', session('id'))->where('id', $id)->first();
        $data = [
            'aktif' => 'Leads',
            'title' => 'Edit Leads',
            'profile' => $getProfile,
            'lead' => $getLead,
        ];
        return \view('addLeads', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $getLead = leadsModel::where('id_user', session('id'))->where('id', $id)->first();
        $request->validate([
            'nama' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
            'kebutuhan' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi!',
            'kontak.required' => 'Kontak wajib diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'kebutuhan.required' => 'Kebutuhan wajib dipilih!',
        ]);

        $data = [
            'id_user' => session('id'),
            'nama' => $request->nama,
            'kontak' => '+62' . $request->kontak,
            'alamat' => $request->alamat,
            'kebutuhan' => $request->kebutuhan,
            'status' => 'baru'
        ];
        $getLead->update($data);

        return \redirect()->to('leads')->with('success', 'Data Leads berhasil diubah!');
    }
    public function updateStatusLeads(Request $request, string $id)
    {
        $getLead = leadsModel::where('id_user', session('id'))->where('id', $id)->first();

        $data = [
            'status' => $request->status
        ];
        $getLead->update($data);

        return \redirect()->to('leads')->with('success', 'Status Leads berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        leadsModel::destroy($id);
        return \redirect()->back()->with('delete', 'Data Leads berhasil dihapus!');
    }
}
