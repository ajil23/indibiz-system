<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PenjualanExport;
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
        return view('admin.penjualan.index', compact('penjualan', 'sales', 'produk', 'lokasi'));
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
        $penjualan = Penjualan::findOrFail($id);

        if ($request->status == "Disetujui") {
            $penjualan->update(['status' => 'Disetujui']);

            return back()->with('success', 'Data berhasil disetujui!');
        } elseif ($request->status == "Ditolak") {
            $penjualan->update([
                'status' => 'Ditolak',
                'keterangan' => $request->keterangan
            ]);

            return back()->with('success', 'Data telah ditolak dengan alasan: ' . $request->keterangan);
        }
    }

    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $month = $request->input('month', now()->month);  // Default ke bulan sekarang jika tidak ada input
        $year = $request->input('year', now()->year);  // Default ke tahun sekarang jika tidak ada input
    
        // Ambil data dengan relasi agar lebih optimal, berdasarkan bulan dan tahun yang dipilih
        $penjualan = Penjualan::with(['user', 'kategori_lokasi', 'jenis_produk'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
    
        // Export ke Excel
        if ($exportType === 'excel') {
            return Excel::download(new PenjualanExport($penjualan), 'penjualan_'.$year.'_'.$month.'.xlsx');
        }
    
        // Export ke PDF
        elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.penjualan', compact('penjualan'))
                ->setPaper('a4', 'landscape'); // Format kertas landscape agar tabel lebih luas
            return $pdf->download('penjualan_'.$year.'_'.$month.'.pdf');
        }
    
        // Jika format tidak valid
        return back()->with('error', 'Format export tidak valid.');
    }
}
