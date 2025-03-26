<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use App\Models\PembelianBbm;
use App\Models\Tnkb;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembelianExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianBBMController extends Controller
{
    public function index()
    {
        $pembelian = PembelianBbm::paginate();
        $tnkb = Tnkb::all();
        $bbm = BahanBakar::all();
        return view('admin.pembelianBBM.index', compact('pembelian', 'tnkb', 'bbm'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pengemudi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'lokasi_tujuan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'lokasi_pembelian' => 'required|string|max:255',
            'tnkb_id' => 'required|exists:tnkb,id',
            'bbm_id' => 'required|exists:bbm,id',
            'foto_nota' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file foto nota
        if ($request->hasFile('foto_nota')) {
            $file = $request->file('foto_nota');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('nota_bbm', $filename, 'public');
        }

        // Simpan data ke database
        PembelianBbm::create([
            'pengemudi' => $request->pengemudi,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'harga' => $request->harga,
            'lokasi_pembelian' => $request->lokasi_pembelian,
            'tnkb_id' => $request->tnkb_id,
            'bbm_id' => $request->bbm_id,
            'foto_nota' => $filePath ?? null, // Simpan path foto
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');

        if ($exportType === 'excel') {
            return Excel::download(new PembelianExport, 'pembelian.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.pembelian', ['data' => PembelianBbm::all()]);
            return $pdf->download('pembelian.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
