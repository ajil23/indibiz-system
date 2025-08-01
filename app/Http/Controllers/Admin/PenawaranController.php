<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Penawaran;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\JenisProduk;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranController extends Controller
{
    public function index(Request $request)
    {
        $sales = User::all();
        $lokasi = Lokasi::all();
        $produk = JenisProduk::all();

        $search = $request->input('search');

        $penawaranQuery = Penawaran::with(['user', 'kategori_lokasi', 'produk']);

        if ($search) {
            $penawaranQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kategori_lokasi', function ($q) use ($search) {
                        $q->where('nama_sektor', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('produk', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    })
                    
                    ->orWhere('nama_lokasi', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('feedback', 'like', '%' . $search . '%')
                    ->orWhere('pic', 'like', '%' . $search . '%');
            });
        }

        $penawaran = $penawaranQuery->paginate(10)->appends(['search' => $search]);

        return view('admin.penawaran.index', compact('sales', 'lokasi', 'penawaran', 'produk'));
    }


    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'feedback' => 'required|string',
        ]);

        // Temukan data penawaran
        $penawaran = Penawaran::findOrFail($id);

        // Update data
        $penawaran->update([
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Feedback dan status penawaran berhasil diperbarui!');
    }

    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $month = $request->input('month', now()->month);  // Default ke bulan sekarang jika tidak ada input
        $year = $request->input('year', now()->year);  // Default ke tahun sekarang jika tidak ada input

        // Ambil data berdasarkan bulan dan tahun yang dipilih
        $data = Penawaran::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->get();

        if ($exportType === 'excel') {
            return Excel::download(new DataExport($data), 'data_bulanan_'.$year.'_'.$month.'.xlsx');
        } elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.pdf', compact('data'))
                    ->setPaper('A4', 'landscape'); // Atur orientasi ke landscape

            return $pdf->download('data_bulanan_'.$year.'_'.$month.'.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
