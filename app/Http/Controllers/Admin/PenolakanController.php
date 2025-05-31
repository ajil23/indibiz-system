<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PenolakanExport;
use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Penawaran;
use App\Models\Penolakan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenolakanController extends Controller
{
    public function index()
    {
        $sales = User::all();
        $lokasi = Lokasi::all();
        $penolakan = Penolakan::paginate(10);
        return view('admin.penolakan.index', compact('sales', 'lokasi', 'penolakan'));
    }

    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $data = Penawaran::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
        if ($exportType === 'excel') {
            return Excel::download(new PenolakanExport, 'data.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.penolakan', compact('data'));
            return $pdf->download('data.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
