<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
use App\Models\Lokasi;
use App\Models\Penolakan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PenolakanController extends Controller
{
    public function index()
    {
        $loginUser = Auth::user()->id;
        $sales = User::where('id', $loginUser)->first();
        $produk = JenisProduk::all();
        $kategori = Lokasi::all();
        $penolakan = Penolakan::where('sales_id', $sales->id)->paginate(10);
        return view('sales.penolakan.index', compact('produk', 'kategori', 'penolakan'));
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
            'kategori_id' => 'required|exists:lokasi,id',
            'produk_id' => 'required|exists:jenis_produk,id',
            'bukti_kunjungan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload file foto bukti kunjungan
        $buktiPath = $request->file('bukti_kunjungan')->store('bukti_kunjungan', 'public');

        // Simpan data ke dalam database
        Penolakan::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'catatan_penolakan' => $request->catatan_penolakan,
            'sales_id' => $request->sales_id,
            'kategori_id' => $request->kategori_id,
            'produk_id' => $request->produk_id,
            'bukti_kunjungan' => $buktiPath,
            'status' => 'Proses',
            'feedback' => null
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data penolakan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'catatan_penolakan' => 'required|string',
            'produk_id' => 'required|exists:jenis_produk,id',
            'kategori_id' => 'required|exists:lokasi,id',
            'bukti_kunjungan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $penolakan = Penolakan::findOrFail($id);

        // Handle upload bukti kunjungan baru jika ada
        if ($request->hasFile('bukti_kunjungan')) {
            // Hapus file lama jika ada
            if ($penolakan->bukti_kunjungan && Storage::disk('public')->exists($penolakan->bukti_kunjungan)) {
                Storage::disk('public')->delete($penolakan->bukti_kunjungan);
            }

            // Simpan file baru
            $buktiPath = $request->file('bukti_kunjungan')->store('bukti_kunjungan', 'public');
            $penolakan->bukti_kunjungan = $buktiPath;
        }

        // Update data lainnya
        $penolakan->update([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'catatan_penolakan' => $request->catatan_penolakan,
            'produk_id' => $request->produk_id,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }


    public function destroy($id)
    {
        $penolakan = Penolakan::findOrFail($id);

        // Hapus file bukti kunjungan jika ada
        if ($penolakan->bukti_kunjungan && Storage::disk('public')->exists($penolakan->bukti_kunjungan)) {
            Storage::disk('public')->delete($penolakan->bukti_kunjungan);
        }

        // Hapus data dari database
        $penolakan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
