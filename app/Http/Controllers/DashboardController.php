<?php

namespace App\Http\Controllers;

use App\Models\leadsModel;
use App\Models\ProjectModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $getProfile = User::findOrFail(session('id'));
        if (session('role') == 'Sales') {
            $getLead = leadsModel::where('id_user', session('id'))->get();
            $getProject = ProjectModel::where('id_user', session('id'))->get();
        } else {
            $getProject = ProjectModel::all();
            $getLead = leadsModel::all();
        }
        $getLeadTerbaru = $getLead->sortByDesc('created_at')->take(5);
        $leadBaru = $getLead->where('status', 'baru')->count();
        $leadProses = $getLead->where('status', 'proses')->count();
        $leadDeal = $getLead->where('status', 'deal')->count();
        $projectProses = $getProject->where('status_project', 'proses')->count();
        $projectSelesai = $getProject->where('status_project', 'selesai')->count();
        $projectApproved = $getProject->where('status', 'approved')->count();
        $projectWaiting = $getProject->where('status', 'waiting approval')->count();
        $projectRejected = $getProject->where('status', 'rejected')->count();

        $data = [
            'aktif' => 'Dashboard',
            'title' => 'Dashboard',
            'profile' => $getProfile,
            'getLeadTerbaru' => $getLeadTerbaru,
            'leadBaru' => $leadBaru,
            'leadProses' => $leadProses,
            'leadDeal' => $leadDeal,
            'projectProses' => $projectProses,
            'projectSelesai' => $projectSelesai,
            'projectApproved' => $projectApproved,
            'projectWaiting' => $projectWaiting,
            'projectRejected' => $projectRejected,
        ];
        return \view('Dashboard', $data);
    }
}
