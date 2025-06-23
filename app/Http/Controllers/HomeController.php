<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return view('admin.index', $stats);
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
    $userId = Auth::user()->id;

    return [
        'totalPenolakan' => DB::table('penolakan')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count(),

        'totalPenawaran' => DB::table('penawaran')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count(),

        'totalPenjualan' => DB::table('penjualan')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count(),

        'totalUser' => DB::table('users')->count(),

        'totalPembelianBBM' => DB::table('pembelian_bbm')
            ->where('sales_id', $userId)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count(),

        'totalPelaporanKendaraan' => DB::table('pelaporan_kendaraan')
            ->where('sales_id', $userId)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count(),
    ];
}

}
