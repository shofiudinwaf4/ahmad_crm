<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\pelangganModel;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerLayananModel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getProfile = User::findOrFail(session('id'));
        $getCustomer = pelangganModel::all();

        $data = [
            'aktif' => 'Customer',
            'title' => 'Customer',
            'profile' => $getProfile,
            'customer' => $getCustomer,
        ];
        return \view('customer', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getProfile = User::findOrFail(session('id'));
        $getCustomer = pelangganModel::with('layanan')->first();

        $data = [
            'aktif' => 'Customer',
            'title' => 'Detail Customer',
            'profile' => $getProfile,
            'customer' => $getCustomer,
        ];
        return \view('detailCustomer', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateIsActiveLayanan(Request $request, string $id)
    {
        DB::transaction(function () use ($request, $id) {

            $layanan = CustomerLayananModel::with('customer')->findOrFail($id);

            $layanan->update([
                'is_active' => $request->is_active
            ]);

            $customer = $layanan->customer;

            $masihAdaAktif = CustomerLayananModel::where('id_customer', $customer->id)
                ->where('is_active', 'aktif')
                ->exists();

            $customer->update([
                'is_active' => $masihAdaAktif ? 'aktif' : 'tidak aktif'
            ]);
        });

        return \redirect()->back()->with('success', 'Status Leads berhasil diubah!');
    }
}
