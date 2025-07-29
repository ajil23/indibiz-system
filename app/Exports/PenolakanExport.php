<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenolakanExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data; // $data adalah hasil_kategorisasi
    }

    public function array(): array
    {
        $result = [];

        foreach ($this->data as $kategori => $items) {
            // Tambahkan header kategori sebagai baris pemisah
            $result[] = [$kategori, '', '', '', ''];

            // Tambahkan data dari setiap item
            foreach ($items as $item) {
                $result[] = [
                    $item->id,
                    $item->nama_lokasi ?? '-',
                    $item->catatan_penolakan,
                    $item->created_at->format('Y-m-d'),
                    $kategori
                ];
            }

            // Tambahkan baris kosong antar kategori (opsional)
            $result[] = ['', '', '', '', ''];
        }

        return $result;
    }

    public function headings(): array
    {
        return ['ID', 'Nama Pelanggan', 'Catatan Penolakan', 'Tanggal', 'Kategori'];
    }
}
