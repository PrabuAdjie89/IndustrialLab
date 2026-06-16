<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DetailBarangSheetExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithTitle
{


    public function collection()
    {
        $data = [];

        // Nomor urut global
        $no = 1;


        $barangs = Barang::with([
            'kategori',
            'detailBarang'
        ])->get();



        foreach ($barangs as $barang) {

            foreach ($barang->detailBarang as $detail) {


                $data[] = [

                    // Nomor tidak reset setiap barang
                    $no++,

                    $barang->kode_barang,

                    $barang->nama_barang,

                    $detail->kode_unit,

                    $detail->status ?? '-',

                    $detail->kondisi ?? '-',


                ];

            }

        }


        return collect($data);
    }





    public function headings(): array
    {
        return [

            'No',

            'Kode Barang',

            'Nama Barang',

            'Kode Unit',

            'Status',

            'Kondisi',

        ];
    }





    public function title(): string
    {
        return 'Detail Barang';
    }






    public function styles(Worksheet $sheet)
    {
        return [

            // Styling header
            1 => [

                'font' => [

                    'bold' => true,

                    'color' => [
                        'rgb' => 'FFFFFF'
                    ],

                    'size' => 11,

                ],


                'fill' => [

                    'fillType' => 'solid',

                    'startColor' => [

                        'rgb' => '1F4E78'

                    ],

                ],


                'alignment' => [

                    'horizontal' => 'center',

                    'vertical' => 'center'

                ],

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




                // Aktifkan filter
                $sheet->setAutoFilter(
                    $sheet->calculateWorksheetDimension()
                );





                // Tinggi header
                $sheet->getRowDimension(1)
                    ->setRowHeight(25);






                $highestRow = $sheet->getHighestRow();

                $highestColumn = $sheet->getHighestColumn();






                // Border seluruh tabel

                $sheet->getStyle(
                    "A1:{$highestColumn}{$highestRow}"
                )
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );







                // Rata tengah untuk kolom tertentu

                $sheet->getStyle(
                    "A1:A{$highestRow}"
                )
                ->getAlignment()
                ->setHorizontal('center');



                $sheet->getStyle(
                    "D1:F{$highestRow}"
                )
                ->getAlignment()
                ->setHorizontal('center');


                $sheet->getStyle(
                    "A1:{$highestColumn}1"
                )
                ->getAlignment()
                ->setHorizontal('center');



            }

        ];

    }

}