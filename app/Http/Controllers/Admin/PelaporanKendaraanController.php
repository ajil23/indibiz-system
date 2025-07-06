<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanKendaraan;
use App\Models\Tnkb;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Exports\PelaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PelaporanKendaraanController extends Controller
{
    public function index(){
        $tnkb = Tnkb::all();
        $pelaporan = PelaporanKendaraan::paginate(10);
        return view('admin.pelaporan.index', compact('pelaporan', 'tnkb'));
    }

    public function exportData(Request $request)
{
    $exportType = $request->input('exportType');
    $month = $request->input('month', now()->month);  // Default bulan sekarang jika tidak ada input
    $year = $request->input('year', now()->year);  // Default tahun sekarang jika tidak ada input

    // Ambil data PelaporanKendaraan berdasarkan bulan dan tahun yang dipilih
    $pelaporan = PelaporanKendaraan::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->get();

    // Export ke Excel
    if ($exportType === 'excel') {
        return Excel::download(new PelaporanExport($pelaporan), 'pelaporan-kendaraan_'.$year.'-'.$month.'.xlsx');
    }

    // Export ke PDF
    elseif ($exportType === 'pdf') {
        $pdf = Pdf::loadView('exports.pelaporan', ['data' => $pelaporan])
            ->setPaper('a4', 'landscape');  // Format kertas landscape untuk PDF
        return $pdf->download('pelaporan-kendaraan_'.$year.'-'.$month.'.pdf');
    }

    // Jika format tidak valid
    return back()->with('error', 'Format tidak valid');
}
}
