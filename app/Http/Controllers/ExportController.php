<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\Penawaran;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');

        if ($exportType === 'excel') {
            return Excel::download(new DataExport, 'data.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.pdf', ['data' => Penawaran::all()]);
            return $pdf->download('data.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
