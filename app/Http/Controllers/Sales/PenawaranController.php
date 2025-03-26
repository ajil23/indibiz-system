<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Penawaran;
use App\Models\User;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    public function index()
    {
        $sales = User::all();
        $lokasi = Lokasi::all();
        $penawaran = Penawaran::paginate(10);
        return view('sales.penawaran.index', compact('penawaran', 'sales', 'lokasi'));
    }

    public function store(Request $request)
    { {
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
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'nomor_hp' => 'required|numeric',
            'nama_lokasi' => 'required|string',
            'alamat' => 'required|string',
            'pic' => 'required|string',
            'keterangan' => 'nullable|string',
            'bukti_kunjungan' => 'nullable|image|max:2048',
        ]);

        $penawaran = Penawaran::findOrFail($id);
        $penawaran->kategori_id = $request->kategori_id;
        $penawaran->tanggal_kunjungan = $request->tanggal_kunjungan;
        $penawaran->nomor_hp = $request->nomor_hp;
        $penawaran->nama_lokasi = $request->nama_lokasi;
        $penawaran->alamat = $request->alamat;
        $penawaran->pic = $request->pic;
        $penawaran->keterangan = $request->keterangan;

        if ($request->hasFile('bukti_kunjungan')) {
            $file = $request->file('bukti_kunjungan');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $penawaran->bukti_kunjungan = $filename;
        }

        $penawaran->save();

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
