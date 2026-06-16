<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangSheetExport implements 
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithTitle
{

    public function collection()
    {
        return Barang::with('kategori')->get()->map(function ($item, $index) {

            return [
                $index + 1,
                $item->kode_barang,
                $item->nama_barang,
                $item->kategori->nama_kategori ?? '-',
                $item->stok,
                $item->bisa_dipinjam ? 'Bisa Dipinjam' : 'Tidak Bisa',
                $item->deskripsi_barang ?? '-',
            ];

        });
    }


    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Stok',
            'Status',
            'Deskripsi'
        ];
    }


    public function title(): string
    {
        return 'Data Barang';
    }


    public function styles(Worksheet $sheet)
    {
        return [

            // Header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]
                ],

                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => '1F4E78'
                    ]
                ],

                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center'
                ]
            ],
        ];
    }


    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function(AfterSheet $event){

                $sheet = $event->sheet->getDelegate();


                // Freeze header
                $sheet->freezePane('A2');


                // Filter tabel
                $sheet->setAutoFilter(
                    $sheet->calculateWorksheetDimension()
                );


                // Border semua tabel
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();


                $sheet->getStyle(
                    "A1:{$highestColumn}{$highestRow}"
                )
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );


                // Tinggi header
                $sheet->getRowDimension(1)->setRowHeight(25);

            }

        ];
    }
}