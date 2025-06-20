<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
use App\Models\Lokasi;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::paginate(10);
        $produk = JenisProduk::all();
        $lokasi = Lokasi::all();
        return view('sales.penjualan.index', compact('penjualan', 'produk', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'lokasi_usaha' => 'required',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'tanggal_penjualan' => 'required|date',
            'kategori_id' => 'required',
            'produk_id' => 'required',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:6000',
        ]);

        // Upload foto KTP
        $pathFotoKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $pathFotoKtp = $request->file('foto_ktp')->store('ktp', 'public');
        }

        Penjualan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'lokasi_usaha' => $request->lokasi_usaha,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
            'catatan_tambahan' => $request->catatan_tambahan ?? null,
            'foto_ktp' => $pathFotoKtp,
            'status' => 'Proses',
            'keterangan' => null,
            'sales_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'lokasi_usaha' => 'required',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'tanggal_penjualan' => 'required|date',
            'kategori_id' => 'required',
            'produk_id' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $penjualan = Penjualan::findOrFail($id);

        // Handle file upload jika ada
        if ($request->hasFile('foto_ktp')) {
            // Simpan file baru
            $pathFotoKtp = $request->file('foto_ktp')->store('ktp', 'public');

            // Hapus file lama jika perlu
            if ($penjualan->foto_ktp && Storage::disk('public')->exists($penjualan->foto_ktp)) {
                Storage::disk('public')->delete($penjualan->foto_ktp);
            }

            $penjualan->foto_ktp = $pathFotoKtp;
        }

        // Update data lainnya
        $penjualan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'lokasi_usaha' => $request->lokasi_usaha,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
            'catatan_tambahan' => $request->catatan_tambahan ?? null,
        ]);

        // Simpan perubahan file foto jika ada
        if (isset($pathFotoKtp)) {
            $penjualan->save();
        }

        return back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
