<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\leadsModel;
use App\Exports\LeadExport;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Exports\ProjectExport;
use App\Models\pelangganModel;
use App\Exports\CustomerExport;
use Illuminate\Foundation\Auth\User;
use Maatwebsite\Excel\Facades\Excel;

use function Symfony\Component\Clock\now;

class ReportController extends Controller
{
    public function Lead(Request $request)
    {
        $query = leadsModel::query();

        // 🔹 Filter sales (optional)
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        if ($request->filled('tanggal')) {

            $tanggal = trim($request->tanggal);

            if (str_contains($tanggal, 'to')) {
                // RANGE TANGGAL
                [$from, $to] = array_map('trim', explode('to', $tanggal));
            } else {
                // SINGLE TANGGAL
                $from = $tanggal;
                $to   = $tanggal;
            }

            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }
        $getLead  = $query
            ->with('sales')
            ->whereNot('status', 'done')
            ->orderBy('created_at', 'desc')
            ->get();

        $getProfile = User::findOrFail(session('id'));
        // $getLead = leadsModel::whereNot('status', 'done')->get();
        $getSales = User::where('jabatan', 'Sales')->get();

        $data = [
            'aktif' => 'Report',
            'title' => 'Report',
            'profile' => $getProfile,
            'lead' => $getLead,
            'sales' => $getSales
        ];
        return \view('reportLead', $data);
    }

    public function exportLead(Request $request)
    {

        $filename = 'report_lead';

        if ($request->filled('id_user')) {
            $user = User::find($request->id_user);
            if ($user) {
                $filename .= '_sales_' . str_replace(' ', '_', strtolower($user->name));
            }
        }

        if ($request->filled('tanggal')) {

            if (str_contains($request->tanggal, 'to')) {
                [$from, $to] = array_map('trim', explode('to', $request->tanggal));

                $filename .= '_' .
                    Carbon::parse($from)->format('d-m-Y') .
                    '_sampai_' .
                    Carbon::parse($to)->format('d-m-Y');
            } else {
                $filename .= '_' . Carbon::parse($request->tanggal)->format('d-m-Y');
            }
        }

        return Excel::download(
            new LeadExport(
                $request->id_user,
                $request->status,
                $request->tanggal
            ),
            $filename . '_' . Carbon::now()->format(
                'd-m-Y'
            ) . '.xlsx'
        );
    }

    public function Project(Request $request)
    {
        $query = ProjectModel::query();

        // 🔹 Filter sales (optional)
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }
        if ($request->filled('status')) {
            $query->where('status_project', $request->status);
        }
        if ($request->filled('tanggal')) {

            $tanggal = trim($request->tanggal);

            if (str_contains($tanggal, 'to')) {
                // RANGE TANGGAL
                [$from, $to] = array_map('trim', explode('to', $tanggal));
            } else {
                // SINGLE TANGGAL
                $from = $tanggal;
                $to   = $tanggal;
            }

            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }
        $getProject  = $query
            ->with(['produk', 'lead', 'sales'])
            ->orderBy('created_at', 'desc')
            ->get();

        $getProfile = User::findOrFail(session('id'));
        $getSales = User::where('jabatan', 'Sales')->get();

        $data = [
            'aktif' => 'Report',
            'title' => 'Report',
            'profile' => $getProfile,
            'project' => $getProject,
            'sales' => $getSales
        ];
        return \view('reportProject', $data);
    }

    public function exportProject(Request $request)
    {

        $filename = 'report_project';

        if ($request->filled('id_user')) {
            $user = User::find($request->id_user);
            if ($user) {
                $filename .= '_sales_' . str_replace(' ', '_', strtolower($user->name));
            }
        }

        if ($request->filled('status')) {
            $filename .= '_' . strtolower($request->status);
        }

        if ($request->filled('tanggal')) {

            if (str_contains($request->tanggal, 'to')) {
                [$from, $to] = array_map('trim', explode('to', $request->tanggal));

                $filename .= '_' .
                    Carbon::parse($from)->format('d-m-Y') .
                    '_sampai_' .
                    Carbon::parse($to)->format('d-m-Y');
            } else {
                $filename .= '_' . Carbon::parse($request->tanggal)->format('d-m-Y');
            }
        }

        return Excel::download(
            new ProjectExport(
                $request->id_user,
                $request->status,
                $request->tanggal
            ),
            $filename . '_' . Carbon::now()->format(
                'd-m-Y'
            ) . '.xlsx'
        );
    }

    public function Customer(Request $request)
    {
        $query = pelangganModel::query();

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }
        if ($request->filled('tanggal')) {

            $tanggal = trim($request->tanggal);

            if (str_contains($tanggal, 'to')) {
                // RANGE TANGGAL
                [$from, $to] = array_map('trim', explode('to', $tanggal));
            } else {
                // SINGLE TANGGAL
                $from = $tanggal;
                $to   = $tanggal;
            }

            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);
        }
        $getCustomer  = $query
            ->orderBy('created_at', 'desc')
            ->get();

        $getProfile = User::findOrFail(session('id'));
        $getSales = User::where('jabatan', 'Sales')->get();

        $data = [
            'aktif' => 'Report',
            'title' => 'Report',
            'profile' => $getProfile,
            'customer' => $getCustomer,
            'sales' => $getSales
        ];
        return \view('reportCustomer', $data);
    }

    public function exportCustomer(Request $request)
    {

        $filename = 'report_customer';

        if ($request->filled('status')) {
            $filename .= '_' . strtolower($request->status);
        }

        if ($request->filled('tanggal')) {

            if (str_contains($request->tanggal, 'to')) {
                [$from, $to] = array_map('trim', explode('to', $request->tanggal));

                $filename .= '_' .
                    Carbon::parse($from)->format('d-m-Y') .
                    '_sampai_' .
                    Carbon::parse($to)->format('d-m-Y');
            } else {
                $filename .= '_' . Carbon::parse($request->tanggal)->format('d-m-Y');
            }
        }

        return Excel::download(
            new CustomerExport(
                $request->status,
                $request->tanggal
            ),
            $filename . '_' . Carbon::now()->format(
                'd-m-Y'
            ) . '.xlsx'
        );
    }
}
