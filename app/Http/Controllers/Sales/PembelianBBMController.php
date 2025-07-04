<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use App\Models\PembelianBbm;
use App\Models\Tnkb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembelianBBMController extends Controller
{
    public function index()
    {
        $pembelian = PembelianBbm::where('sales_id', Auth::user()->id)->latest()->paginate(10);
        $tnkb = Tnkb::all();
        $bbm = BahanBakar::all();
        return view('sales.pembelianBBM.index', compact('pembelian', 'tnkb', 'bbm'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'sales_id' => 'required',
            'tanggal_pembelian' => 'required|date',
            'lokasi_tujuan' => 'required|string|max:255',
            'harga' => 'required|min:0',
            'total_pembelian' => 'required|min:0',
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
            'sales_id' => $request->sales_id,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'harga' => $request->harga,
            'total_pembelian' => $request->total_pembelian,
            'lokasi_pembelian' => $request->lokasi_pembelian,
            'tnkb_id' => $request->tnkb_id,
            'bbm_id' => $request->bbm_id,
            'foto_nota' => $filePath ?? null, // Simpan path foto
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'keterangan' => 'nullable|string',
        ]);

        // Ambil data yang akan diperbarui
        $pembelian = PembelianBbm::findOrFail($id);

        // Update data di database
        $pembelian->update([
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return back()->with('success', 'Data berhasil diubah!');
    }
}
