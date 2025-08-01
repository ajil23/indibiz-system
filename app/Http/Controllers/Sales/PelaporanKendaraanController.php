<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\PelaporanKendaraan;
use App\Models\Tnkb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelaporanKendaraanController extends Controller
{
    public function index()
    {
        $tnkb = Tnkb::all();
        $pelaporan = PelaporanKendaraan::where('sales_id', Auth::user()->id)->latest()->paginate(10);
        return view('sales.pelaporan.index', compact('tnkb', 'pelaporan'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'sales_id' => 'required',
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
            'sales_id' => $request->sales_id,
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

    public function update(Request $request, $id)
    {
        // Ambil data pelaporan berdasarkan ID
        $pelaporan = PelaporanKendaraan::findOrFail($id);

        // Validasi data input
        $request->validate([
            'keterangan' => 'nullable|string',
        ]);

        // Update data ke database
        $pelaporan->update([
            'keterangan' => $request->keterangan,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data pelaporan kendaraan berhasil diperbarui!');
    }
}
