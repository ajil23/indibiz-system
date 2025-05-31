<?php

namespace App\Exports;

use App\Models\Penawaran;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Penawaran::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
    }
}
