<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PenolakanExport;
use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
use App\Models\Lokasi;
use App\Models\Penawaran;
use App\Models\Penolakan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PenolakanController extends Controller
{

public function index(Request $request){
    $sales = User::all();
    $lokasi = Lokasi::all();
    $produk = JenisProduk::all();
    $kategoriLokasi = Lokasi::all();

    $search = strtolower($request->input('search'));

    // Daftar mapping kategori penolakan
    $kategori_penolakan = [
        'Sudah menggunakan provider lain' => [
            'provider lain', 'biznet', 'indihome', 'first media', 'myrepublic',
            'pakai provider', 'sudah pakai', 'langganan internet', 'pakai internet', 'provider sendiri'
        ],
        'Tidak tertarik' => [
            'tidak tertarik', 'tidak berminat', 'belum perlu', 'nggak butuh',
            'tidak butuh', 'kurang minat'
        ],
        'Masih menggunakan paket data' => [
            'pakai kuota', 'pakai hp', 'pakai data', 'pakai hotspot', 'pakai tethering',
            'masih pake data'
        ],
        'Harga mahal' => [
            'mahal', 'biaya tinggi', 'harga tinggi', 'gaji tidak cukup', 'kemahalan', 'tidak sesuai budget'
        ],
        'Tidak ada yang bisa memutuskan' => [
            'tanya suami', 'tanya istri', 'tanya orang tua', 'bukan keputusan saya', 'bukan yang menentukan'
        ],
        'Lokasi tidak sesuai / tidak tercover' => [
            'lokasi tidak sesuai', 'jauh', 'tidak strategis', 'tidak terjangkau',
            'jaringan belum masuk', 'tidak tercover', 'wilayah belum tersedia'
        ],
        'Tidak ada orang / rumah kosong' => [
            'tidak ada orang', 'rumah kosong', 'tidak bertemu', 'kosong', 'tidak ada penghuni'
        ],
        'Baru pindah / akan pindah' => [
            'baru pindahan', 'akan pindah', 'sebentar lagi pindah', 'tidak menetap'
        ],
        'Review buruk / takut gangguan' => [
            'sinyal jelek', 'lemot', 'takut gangguan', 'review jelek', 'katanya jelek', 'takut lambat'
        ],
        'Masih kontrak dengan provider lama' => [
            'belum habis kontrak', 'masih kontrak', 'kena penalti', 'terikat provider'
        ],
        'Kebutuhan tidak sesuai' => [
            'jarang di rumah', 'tidak terlalu butuh', 'hanya untuk wa', 'pakai hp saja',
            'tidak perlu kencang'
        ],
        'Waktu tidak tepat / sedang sibuk' => [
            'lagi kerja', 'tidak sempat', 'nanti saja', 'lagi sibuk'
        ],
        'Takut penipuan / tidak percaya' => [
            'takut penipuan', 'takut scam', 'tidak percaya', 'sales palsu', 'tidak yakin'
        ],
        'Sudah pernah ditawari' => [
            'sudah ditawari', 'kemarin sudah ada', 'sudah pernah datang', 'sudah tahu'
        ],
        'Lainnya' => [
            'nanti saya pikir-pikir', 'lihat dulu', 'belum tahu', 'lain kali', 'entah', 'belum bisa jawab'
        ]
    ];

    $penolakanQuery = Penolakan::with(['user', 'jenis_produk']);

    // Proses pencarian jika ada input
    if ($search) {
        $matchedKategori = null;

        foreach ($kategori_penolakan as $kategori => $keywords) {
            if (Str::contains(strtolower($kategori), $search)) {
                $matchedKategori = $kategori;
                break;
            }
        }

        if ($matchedKategori) {
            $keywords = $kategori_penolakan[$matchedKategori];
            $penolakanQuery->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('catatan_penolakan', 'like', '%' . $keyword . '%');
                }
            });
        } else {
            // Tidak ada kecocokan kategori → kosongkan hasil
            $penolakanQuery->whereRaw('0=1');
        }
    }

    $penolakan = $penolakanQuery->paginate(10)->appends(['search' => $request->input('search')]);
   
        return view('admin.penolakan.index', compact('sales', 'lokasi', 'penolakan', 'produk', 'kategoriLokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string',
        ]);

        $penolakan = Penolakan::findOrFail($id);

        // Update hanya field yang diperlukan
        $penolakan->feedback = $request->feedback;

        // Update status jika dikirim (opsional)
        if ($request->has('status')) {
            $penolakan->status = $request->status;
        }

        $penolakan->save();

        return back()->with('success', 'Feedback berhasil disimpan!');
    }


    public function exportData(Request $request)
    {
        $exportType = $request->input('exportType');
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Ambil data berdasarkan bulan dan tahun
        $data = Penolakan::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->get();

        // Kategori mapping keyword
        $kategori_penolakan = [
            'Sudah menggunakan provider lain' => [
                'provider lain', 'biznet', 'indihome', 'first media', 'myrepublic',
                'pakai provider', 'sudah pakai', 'langganan internet', 'pakai internet', 'provider sendiri'
            ],
        
            'Tidak tertarik' => [
                'tidak tertarik', 'tidak berminat', 'belum perlu', 'nggak butuh',
                'tidak butuh', 'kurang minat'
            ],
        
            'Masih menggunakan paket data' => [
                'pakai kuota', 'pakai hp', 'pakai data', 'pakai hotspot', 'pakai tethering',
                'masih pake data'
            ],
        
            'Harga mahal' => [
                'mahal', 'biaya tinggi', 'harga tinggi', 'gaji tidak cukup', 'kemahalan', 'tidak sesuai budget'
            ],
        
            'Tidak ada yang bisa memutuskan' => [
                'tanya suami', 'tanya istri', 'tanya orang tua', 'bukan keputusan saya', 'bukan yang menentukan'
            ],
        
            'Lokasi tidak sesuai / tidak tercover' => [
                'lokasi tidak sesuai', 'jauh', 'tidak strategis', 'tidak terjangkau',
                'jaringan belum masuk', 'tidak tercover', 'wilayah belum tersedia'
            ],
        
            'Tidak ada orang / rumah kosong' => [
                'tidak ada orang', 'rumah kosong', 'tidak bertemu', 'kosong', 'tidak ada penghuni'
            ],
        
            'Baru pindah / akan pindah' => [
                'baru pindahan', 'akan pindah', 'sebentar lagi pindah', 'tidak menetap'
            ],
        
            'Review buruk / takut gangguan' => [
                'sinyal jelek', 'lemot', 'takut gangguan', 'review jelek', 'katanya jelek', 'takut lambat'
            ],
        
            'Masih kontrak dengan provider lama' => [
                'belum habis kontrak', 'masih kontrak', 'kena penalti', 'terikat provider'
            ],
        
            'Kebutuhan tidak sesuai' => [
                'jarang di rumah', 'tidak terlalu butuh', 'hanya untuk wa', 'pakai hp saja',
                'tidak perlu kencang'
            ],
        
            'Waktu tidak tepat / sedang sibuk' => [
                'lagi kerja', 'tidak sempat', 'nanti saja', 'lagi sibuk'
            ],
        
            'Takut penipuan / tidak percaya' => [
                'takut penipuan', 'takut scam', 'tidak percaya', 'sales palsu', 'tidak yakin'
            ],
        
            'Sudah pernah ditawari' => [
                'sudah ditawari', 'kemarin sudah ada', 'sudah pernah datang', 'sudah tahu'
            ],
        
            'Lainnya' => [
                'nanti saya pikir-pikir', 'lihat dulu', 'belum tahu', 'lain kali', 'entah', 'belum bisa jawab'
            ]
        ];
        

        // Proses kategorisasi
        $hasil_kategorisasi = [];

        foreach ($data as $item) {
            $ditemukan = false;
            $catatan = strtolower($item->catatan_penolakan);

            foreach ($kategori_penolakan as $kategori => $keywords) {
                foreach ($keywords as $keyword) {
                    if (Str::contains($catatan, $keyword)) {
                        $hasil_kategorisasi[$kategori][] = $item;
                        $ditemukan = true;
                        break 2;
                    }
                }
            }

            if (!$ditemukan) {
                $hasil_kategorisasi['Lainnya'][] = $item;
            }
        }

        if ($exportType === 'excel') {
            return Excel::download(new PenolakanExport($hasil_kategorisasi), 'data_'.$year.'_'.$month.'.xlsx');
        } elseif ($exportType === 'pdf') {
            $data = $hasil_kategorisasi;
            $pdf = Pdf::loadView('exports.penolakan', compact('data'))
                    ->setPaper('A4', 'landscape');

            return $pdf->download('data_'.$year.'_'.$month.'.pdf');
        }

        return back()->with('error', 'Format tidak valid');
    }
}
 