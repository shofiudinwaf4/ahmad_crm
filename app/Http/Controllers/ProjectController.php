<?php

namespace App\Http\Controllers;

use App\Models\CustomerLayananModel;
use App\Models\User;
use App\Models\leadsModel;
use App\Models\produkModel;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Models\pelangganModel;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjectModel::query();

        // 🔹 Filter sales (optional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $getProject  = $query
            ->with(['produk', 'lead', 'sales'])
            ->orderBy('created_at', 'desc')
            ->get();

        $getProfile = User::findOrFail(session('id'));
        $getLead = leadsModel::with('project')->where('id_user', \session('id'))->where('status', 'deal')->get();
        // $getProject = ProjectModel::with(['produk', 'lead', 'sales'])->get();

        $data = [
            'aktif' => 'Project',
            'title' => 'Project',
            'profile' => $getProfile,
            'project' => $getProject,
            'lead' => $getLead,
        ];
        return \view('project', $data);
    }

    public function done()
    {
        $getProfile = User::findOrFail(session('id'));
        $getLead = leadsModel::with('project')->where('id_user', \session('id'))->where('status', 'done')->get();
        $getProject = ProjectModel::with(['produk', 'lead'])->where('id_user', \session('id'))->get();


        $data = [
            'aktif' => 'Project',
            'title' => 'Pencapaian Project',
            'profile' => $getProfile,
            'project' => $getProject,
            'lead' => $getLead,
            // 'waitingApproval' => $waitingApproval,
            // 'reject' => $reject,
        ];
        return \view('doneProject', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $getProfile = User::findOrFail(session('id'));
        $getLead = leadsModel::where('id', $id)->first();
        $getProduk = produkModel::all();
        $getProject = ProjectModel::with('produk')->where('id_lead', $id)->where('id_user', \session('id'))->get();

        $data = [
            'aktif' => 'Project',
            'title' => 'Tambah Produk Leads',
            'profile' => $getProfile,
            'lead' => $getLead,
            'produk' => $getProduk,
            'isEdit' => $getProject->count() > 0

        ];
        return \view('addProdukProject', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'items.*.id_produk' => 'required|exists:produks,id',
            'items.*.harga_jual' => 'required',
            'items.*.permintaan_harga' => 'required',
        ]);

        foreach ($request->items as $item) {

            $hargaJual = preg_replace('/\D/', '', $item['harga_jual']);
            $permintaan = preg_replace('/\D/', '', $item['permintaan_harga']);
            $approvalStatus = $hargaJual > $permintaan
                ? 'waiting approval'
                : 'approved';

            ProjectModel::create([
                'id_user' => \session('id'),
                'id_lead' => $id,
                'id_produk' => $item['id_produk'],
                'harga_jual' => $hargaJual,
                'permintaan_harga' => $permintaan,
                'status' => $approvalStatus,
            ]);
        }
        return \redirect()->to('project')->with('success', 'Data Produk berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getProfile = User::findOrFail(session('id'));
        $getLead = leadsModel::where('id', $id)->first();
        $getProject = ProjectModel::with('produk')->where('id_lead', $id)->where('id_user', \session('id'))->get();

        $data = [
            'aktif' => 'Project',
            'title' => 'Bayar',
            'profile' => $getProfile,
            'lead' => $getLead,
            'project' => $getProject
        ];
        return \view('bayar', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $getProfile = User::findOrFail(session('id'));
        $getLead = leadsModel::where('id', $id)->first();
        $getProject = ProjectModel::with('produk')->where('id_lead', $id)->where('id_user', \session('id'))->get();
        $getProduk = produkModel::all();

        $data = [
            'aktif' => 'Project',
            'title' => 'Edit Produk Leads',
            'profile' => $getProfile,
            'lead' => $getLead,
            'project' => $getProject,
            'produk' => $getProduk,
            'isEdit' => $getProject->count() > 0
        ];
        return \view('addProdukProject', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ProjectModel::where('id_lead', $id)->delete();

        foreach ($request->items as $item) {
            $hargaJual = preg_replace('/\D/', '', $item['harga_jual']);
            $permintaan = preg_replace('/\D/', '', $item['permintaan_harga']);

            $approvalStatus = $hargaJual > $permintaan
                ? 'waiting approval'
                : 'approved';

            ProjectModel::create([
                'id_user' => \session('id'),
                'id_lead' => $id,
                'id_produk' => $item['id_produk'],
                'harga_jual' => $hargaJual,
                'permintaan_harga' => $permintaan,
                'status' => $approvalStatus,
            ]);
        }
        return \redirect()->to('project')->with('success', 'Data Produk berhasil diperbarui!');
    }
    public function changeCustomer(Request $request)
    {
        $getProject = ProjectModel::with(['produk', 'lead'])->where('id_lead', $request->id_lead)->get();
        $getlead = leadsModel::where('id', $request->id_lead)->first();
        if ($request->jenis_lead == 'baru') {
            DB::transaction(function () use ($getProject, $getlead, $request) {

                $getlead->update(['status' => 'done']);
                $dataCustomer = [
                    'id_user' => \session('id'),
                    'nama' => $getlead->nama,
                    'no_pelanggan' => $this->generateNoPelanggan(),
                    'kontak' => $getlead->kontak,
                    'alamat' => $getlead->alamat,
                    'is_active' => 'aktif'
                ];
                $pelanggan = pelangganModel::create($dataCustomer);
                foreach ($getProject as $projects) {
                    $projects->update(['status_project' => 'selesai']);

                    $dataLayanan = [
                        'no_langganan' => $this->generateNoLangganan(),
                        'id_customer' => $pelanggan->id,
                        'nama_layanan' => $projects->produk->nama_produk,
                        'tagihan' => $projects->permintaan_harga,
                    ];
                    CustomerLayananModel::create($dataLayanan);
                }
            });
            return \redirect()->to('project')->with('success', 'Project berhasil diselesaikan!');
        } else {
            $request->validate([
                'no_pelanggan' => 'required',
            ], [
                'no_pelanggan.required' => 'No Pelanggan wajib diisi!',
            ]);
            DB::transaction(function () use ($getProject, $getlead, $request) {

                $getlead->update(['status' => 'done']);
                $getCustomer = pelangganModel::where('no_pelanggan', $request->no_pelanggan)->first();
                foreach ($getProject as $projects) {
                    $projects->update(['status_project' => 'selesai']);

                    $dataLayanan = [
                        'no_langganan' => $this->generateNoLangganan(),
                        'id_customer' => $getCustomer->id,
                        'nama_layanan' => $projects->produk->nama,
                        'tagihan' => $projects->permintaan_harga,
                    ];
                    CustomerLayananModel::create($dataLayanan);
                }
            });
            return \redirect()->to('project')->with('success', 'Project berhasil diselesaikan!');
        }
    }

    public function generateNoPelanggan()
    {
        do {
            $noPelanggan = 'CUST-' . rand(100000, 999999);
        } while (pelangganModel::where('no_pelanggan', $noPelanggan)->exists());

        return $noPelanggan;
    }

    public static function generateNoLangganan()
    {
        do {
            $no = rand(100000, 999999);
        } while (DB::table('customer_layanan')
            ->where('no_langganan', $no)
            ->exists()
        );

        return $no;
    }

    public function updateApprovalProject(Request $request, string $id)
    {
        $getProject = ProjectModel::where('id', $id)->first();

        $data = [
            'status' => $request->status
        ];
        $getProject->update($data);

        return \redirect()->to('project')->with('success', 'Status Project berhasil diubah!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
