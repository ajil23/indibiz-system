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
        $loginUser = Auth::user()->id;
        $sales = User::where('id', $loginUser)->first();
        $penjualan = Penjualan::where('sales_id', $sales->id)->paginate(10);
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
        $penjualan = Penjualan::findOrFail($id);

        // Update data lainnya
        $penjualan->update([
            'catatan_tambahan' => $request->catatan_tambahan ?? null,
        ]);

        // Simpan perubahan file foto jika ada
        if (isset($pathFotoKtp)) {
            $penjualan->save();
        }

        return back()->with('success', 'Data berhasil diubah!');
    }

}
