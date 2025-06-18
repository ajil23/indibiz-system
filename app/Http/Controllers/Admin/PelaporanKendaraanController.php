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

        if ($exportType === 'excel') {
            return Excel::download(new PelaporanExport, 'pelaporan-kendaraan.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.pelaporan', ['data' => PelaporanKendaraan::all()]);
            return $pdf->download('pelaporan-kendaraan.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
