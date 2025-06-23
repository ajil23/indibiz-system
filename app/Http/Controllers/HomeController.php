<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'admin' || $user->role == 'pimpinan') {
            $stats = $this->getMonthlyStats();
            $chartLabels = [];
            $chartData = [];

            for ($i = 1; $i <= 12; $i++) {
                $chartLabels[] = Carbon::create()->month($i)->format('M');

                $query = DB::table('penjualan')->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year);

                if (Auth::user()->role === 'sales') {
                    $query->where('sales_id', Auth::id());
                }

                $chartData[] = $query->count();
            }

            $latestUsers = DB::table('users')->latest()->limit(10)->get();

            return view('admin.index', [
                'stats' => $stats,
                'chartData' => $chartData, 
                'chartLabels' => $chartLabels, 
                'latestUsers' => $latestUsers  

            ]);
        } elseif ($user->role == 'sales') {
            $stats = $this->getMonthlyStats();
            return view('sales.index', $stats);
        }
        return redirect()->intended('/');
    }

    private function getMonthlyStats()
{
    $bulan = Carbon::now()->month;
    $tahun = Carbon::now()->year;
    $user = Auth::user();
    $userId = $user->id;
    $role = $user->role;

    // Helper function untuk menambahkan filter sales jika perlu
    $applySalesFilter = function ($query, $table) use ($role, $userId) {
        // Pastikan hanya menambahkan filter jika tabel memiliki kolom sales_id
        $hasSalesColumn = Schema::hasColumn($table, 'sales_id');
        if ($role === 'sales' && $hasSalesColumn) {
            $query->where('sales_id', $userId);
        }
        return $query;
    };

    // Query masing-masing data
    $penolakanQuery = DB::table('penolakan')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);
    $penawaranQuery = DB::table('penawaran')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);
    $penjualanQuery = DB::table('penjualan')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);
    $pembelianQuery = DB::table('pembelian_bbm')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);
    $pelaporanQuery = DB::table('pelaporan_kendaraan')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);

    // Terapkan filter sales jika role = sales
    $penolakanQuery = $applySalesFilter($penolakanQuery, 'penolakan');
    $penawaranQuery = $applySalesFilter($penawaranQuery, 'penawaran');
    $penjualanQuery = $applySalesFilter($penjualanQuery, 'penjualan');
    $pembelianQuery = $applySalesFilter($pembelianQuery, 'pembelian_bbm');
    $pelaporanQuery = $applySalesFilter($pelaporanQuery, 'pelaporan_kendaraan');

    return [
        'totalPenolakan' => $penolakanQuery->count(),
        'totalPenawaran' => $penawaranQuery->count(),
        'totalPenjualan' => $penjualanQuery->count(),
        'totalUser' => DB::table('users')->count(), // Tetap semua user
        'totalPembelianBBM' => $pembelianQuery->count(),
        'totalPelaporanKendaraan' => $pelaporanQuery->count(),
    ];
}



}
