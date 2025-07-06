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
        $month = $request->input('month', now()->month);  // Default ke bulan sekarang jika tidak ada input
        $year = $request->input('year', now()->year);  // Default ke tahun sekarang jika tidak ada input

        // Ambil data berdasarkan bulan dan tahun yang dipilih
        $data = Penolakan::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->get();

        if ($exportType === 'excel') {
            return Excel::download(new PenolakanExport($data), 'data_'.$year.'_'.$month.'.xlsx');
        } elseif ($exportType === 'pdf') {
            // Set orientasi kertas untuk PDF (optional)
            $pdf = Pdf::loadView('exports.penolakan', compact('data'))
                    ->setPaper('A4', 'landscape');  // Bisa diganti menjadi 'portrait' sesuai kebutuhan

            return $pdf->download('data_'.$year.'_'.$month.'.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
