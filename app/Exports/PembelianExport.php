<?php

namespace App\Exports;

use App\Models\PembelianBbm;
use Maatwebsite\Excel\Concerns\FromCollection;

class PembelianExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PembelianBbm::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
    }
}
