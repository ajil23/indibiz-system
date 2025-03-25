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

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'pengemudi' => 'required|string|max:255',
            'tanggal_penggunaan' => 'required|date',
            'lokasi_tujuan' => 'required|string|max:255',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jumlah_odo' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto_odo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tnkb_id' => 'required|exists:tnkb,id',
        ]);

        // Proses upload file foto odo
        if ($request->hasFile('foto_odo')) {
            $file = $request->file('foto_odo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/odo', $filename, 'public');
        }

        // Simpan data ke database
        PelaporanKendaraan::create([
            'pengemudi' => $request->pengemudi,
            'tanggal_penggunaan' => $request->tanggal_penggunaan,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'jumlah_odo' => $request->jumlah_odo,
            'keterangan' => $request->keterangan,
            'foto_odo' => isset($filePath) ? $filePath : null,
            'tnkb_id' => $request->tnkb_id,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data pelaporan BBM berhasil disimpan!');
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
