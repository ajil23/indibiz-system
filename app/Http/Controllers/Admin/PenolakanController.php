<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PenolakanExport;
use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
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
        $produk = JenisProduk::all();
        $kategori = Lokasi::all();
        return view('admin.penolakan.index', compact('sales', 'lokasi', 'penolakan', 'produk', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string',
        ]);

        $penolakan = Penolakan::findOrFail($id);

        // Update hanya field yang diperlukan
        $penolakan->feedback = $request->feedback;

        // Update status jika dikirim (opsional)
        if ($request->has('status')) {
            $penolakan->status = $request->status;
        }

        $penolakan->save();

        return back()->with('success', 'Feedback berhasil disimpan!');
    }


    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $data = Penolakan::whereMonth('created_at', now()->month)
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
