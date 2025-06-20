<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\JenisProduk;
use App\Models\Penawaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenawaranController extends Controller
{
    public function index()
    {
        $sales = User::all();
        $lokasi = Lokasi::all();
        $produk = JenisProduk::all();
        $penawaran = Penawaran::paginate(10);
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
            'kategori_id' => 'required|exists:lokasi,id',
            'produk_id' => 'required|exists:jenis_produk,id',
            'tanggal_kunjungan' => 'required|date',
            'nomor_hp' => 'required|numeric',
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'bukti_kunjungan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $penawaran = Penawaran::findOrFail($id);

        // Hapus file lama jika ada file baru diunggah
        if ($request->hasFile('bukti_kunjungan')) {
            // Hapus file lama jika ada
            if ($penawaran->bukti_kunjungan && Storage::disk('public')->exists($penawaran->bukti_kunjungan)) {
                Storage::disk('public')->delete($penawaran->bukti_kunjungan);
            }

            // Upload file baru
            $file = $request->file('bukti_kunjungan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_kunjungan', $filename, 'public');

            $penawaran->bukti_kunjungan = $path;
        }

        // Update kolom lainnya
        $penawaran->update([
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'nomor_hp' => $request->nomor_hp,
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
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
