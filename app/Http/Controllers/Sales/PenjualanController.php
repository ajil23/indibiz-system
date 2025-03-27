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

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::paginate(10);
        $sales = User::all();
        $produk = JenisProduk::all();
        $lokasi = Lokasi::all();
        return view('sales.penjualan.index', compact('penjualan', 'sales', 'produk', 'lokasi'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'lokasi_usaha' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'koordinat' => 'required',
            'kode_partner' => 'required',
            'sales_id' => 'required',
            'kategori_id' => 'required',
            'produk_id' => 'required',
        ]);

        Penjualan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'lokasi_usaha' => $request->lokasi_usaha,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'koordinat' => $request->koordinat,
            'kode_partner' => $request->koordinat,
            'status' => 'Proses',
            'keterangan' => NULL,
            'sales_id' => $request->sales_id,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
        ]);
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'lokasi_usaha' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'koordinat' => 'required',
            'kode_partner' => 'required',
            'sales_id' => 'required',
            'kategori_id' => 'required',
            'produk_id' => 'required',
        ]);

        // Cari data berdasarkan ID
        $penjualan = Penjualan::findOrFail($id);

        // Update data
        $penjualan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'lokasi_usaha' => $request->lokasi_usaha,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'koordinat' => $request->koordinat,
            'kode_partner' => $request->kode_partner,
            'sales_id' => $request->sales_id,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
        ]);

        return back()->with('success', 'Data berhasil diubah!');
    }
    
    public function destroy($id){
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
