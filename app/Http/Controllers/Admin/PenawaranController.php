<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Penawaran;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranController extends Controller
{
    public function index()
    {
        $sales = User::all();
        $lokasi = Lokasi::all();
        $penawaran = Penawaran::paginate(10);
        return view('admin.penawaran.index', compact('sales', 'lokasi', 'penawaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'alamat' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'pic' => 'required',
            'nomor_hp' => 'required',
            'bukti_kunjungan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required',
            'sales_id' => 'required',
            'kategori_id' => 'required',
        ]);

        // Proses Upload Gambar
        if ($request->hasFile('bukti_kunjungan')) {
            $file = $request->file('bukti_kunjungan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_kunjungan', $filename, 'public');
        }

        Penawaran::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'pic' => $request->pic,
            'nomor_hp' => $request->nomor_hp,
            'bukti_kunjungan' => $path ?? null, // simpan path nya
            'keterangan' => $request->keterangan,
            'sales_id' => $request->sales_id,
            'kategori_id' => $request->kategori_id,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }
    
    public function update(Request $request, $id){
        $request->validate([
            'feedback' => 'required',
        ]);
        $penawaran = Penawaran::findOrFail($id);
        $penawaran->update([
            'feedback' => $request->feedback,
        ]);
        return back()->with('success', 'Feedback berhasil disimpan!');
    }

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
