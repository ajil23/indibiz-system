<?php

namespace App\Exports;

use App\Models\Penolakan;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenolakanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Penolakan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
    }
}
