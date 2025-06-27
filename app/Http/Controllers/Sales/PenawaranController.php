<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\JenisProduk;
use App\Models\Penawaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PenawaranController extends Controller
{
    public function index()
    {
        $loginUser = Auth::user()->id;
        $sales = User::where('id', $loginUser)->first();
        $lokasi = Lokasi::all();
        $produk = JenisProduk::all();
        $penawaran = Penawaran::where('sales_id', $sales->id)->paginate(10);
        
        return view('sales.penawaran.index', compact('penawaran', 'sales', 'lokasi', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'pic' => 'required|string|max:255',
            'nomor_hp' => 'required|regex:/^[0-9]+$/',
            'bukti_kunjungan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string',
            'sales_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:lokasi,id',
            'produk_id' => 'required|exists:jenis_produk,id',
        ]);

        // Upload foto bukti kunjungan
        $buktiPath = $request->file('bukti_kunjungan')->store('bukti_kunjungan', 'public');

        Penawaran::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'pic' => $request->pic,
            'nomor_hp' => $request->nomor_hp,
            'bukti_kunjungan' => $buktiPath,
            'keterangan' => $request->keterangan,
            'status' => 'Proses',
            'feedback' => null,
            'sales_id' => $request->sales_id,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
        ]);

        return redirect()->back()->with('success', 'Data penawaran berhasil disimpan.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'nullable|string',
        ]);

        $penawaran = Penawaran::findOrFail($id);

        // Update kolom lainnya
        $penawaran->update([
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }


    public function destroy($id)
    {
        $penawaran = Penawaran::findOrFail($id);

        // Hapus file bukti kunjungan jika ada
        if ($penawaran->bukti_kunjungan && file_exists(public_path('uploads/' . $penawaran->bukti_kunjungan))) {
            unlink(public_path('uploads/' . $penawaran->bukti_kunjungan));
        }

        $penawaran->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
