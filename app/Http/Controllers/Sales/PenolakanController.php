<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
use App\Models\Penolakan;
use App\Models\User;
use Illuminate\Http\Request;

class PenolakanController extends Controller
{
    public function index()
    {
        $produk = JenisProduk::all();
        $sales = User::all();
        $penolakan = Penolakan::paginate(10);
        return view('sales.penolakan.index', compact('produk', 'sales', 'penolakan'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'catatan_penolakan' => 'required|string',
            'sales_id' => 'required|exists:users,id',
            'produk_id' => 'required|exists:jenis_produk,id',
        ]);

        // Simpan data ke dalam database
        Penolakan::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'catatan_penolakan' => $request->catatan_penolakan,
            'sales_id' => $request->sales_id,
            'produk_id' => $request->produk_id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'catatan_penolakan' => 'required|string',
            'produk_id' => 'required|exists:jenis_produk,id',
        ]);

        $penolakan = Penolakan::findOrFail($id);

        $penolakan->update([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'catatan_penolakan' => $request->catatan_penolakan,
            'produk_id' => $request->produk_id,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $penolakan = Penolakan::findOrFail($id);
        $penolakan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
