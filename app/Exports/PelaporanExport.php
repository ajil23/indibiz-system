<?php

namespace App\Exports;

use App\Models\PelaporanKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelaporanExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PelaporanKendaraan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();;
    }
}
