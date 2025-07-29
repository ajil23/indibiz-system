<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use App\Models\PembelianBbm;
use App\Models\Tnkb;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembelianExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianBBMController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pembelianQuery = PembelianBbm::with(['tnkb', 'bbm', 'user']);

        if ($search) {
            $pembelianQuery->where(function ($query) use ($search) {
                $query->where('tanggal_pembelian', 'like', '%' . $search . '%')
                    ->orWhere('lokasi_tujuan', 'like', '%' . $search . '%')
                    ->orWhere('lokasi_pembelian', 'like', '%' . $search . '%')
                    ->orWhere('harga', 'like', '%' . $search . '%')
                    ->orWhere('total_pembelian', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')

                    // Relasi ke tabel users (nama sales)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })

                    // Relasi ke tabel tnkb (nomor polisi)
                    ->orWhereHas('tnkb', function ($q) use ($search) {
                        $q->where('nomor_polisi', 'like', '%' . $search . '%');
                    })

                    // Relasi ke tabel bbm (jenis bbm)
                    ->orWhereHas('bbm', function ($q) use ($search) {
                        $q->where('nama_bbm', 'like', '%' . $search . '%');
                    });                    
            });
        }

        $pembelian = $pembelianQuery->paginate(10)->appends(['search' => $search]);

        $tnkb = Tnkb::all();
        $bbm = BahanBakar::all();

        return view('admin.pembelianBBM.index', compact('pembelian', 'tnkb', 'bbm', 'search'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pengemudi' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'lokasi_tujuan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'lokasi_pembelian' => 'required|string|max:255',
            'tnkb_id' => 'required|exists:tnkb,id',
            'bbm_id' => 'required|exists:bbm,id',
            'foto_nota' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file foto nota
        if ($request->hasFile('foto_nota')) {
            $file = $request->file('foto_nota');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('nota_bbm', $filename, 'public');
        }

        // Simpan data ke database
        PembelianBbm::create([
            'pengemudi' => $request->pengemudi,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'harga' => $request->harga,
            'lokasi_pembelian' => $request->lokasi_pembelian,
            'tnkb_id' => $request->tnkb_id,
            'bbm_id' => $request->bbm_id,
            'foto_nota' => $filePath ?? null, // Simpan path foto
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $month = $request->input('month', now()->month);  // Default bulan sekarang
        $year = $request->input('year', now()->year);  // Default tahun sekarang
    
        // Ambil data PembelianBbm berdasarkan bulan dan tahun yang dipilih
        $pembelian = PembelianBbm::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
    
        // Export ke Excel
        if ($exportType === 'excel') {
            return Excel::download(new PembelianExport($pembelian), 'pembelian_'.$year.'-'.$month.'.xlsx');
        }
    
        // Export ke PDF
        elseif ($exportType === 'pdf') {
            $pdf = Pdf::loadView('exports.pembelian', ['data' => $pembelian])
                ->setPaper('a4', 'landscape');  // Format kertas landscape
            return $pdf->download('pembelian_'.$year.'-'.$month.'.pdf');
        }
    
        // Jika format tidak valid
        return back()->with('error', 'Format tidak valid');
    }
}
