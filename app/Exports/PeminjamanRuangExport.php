<?php

namespace App\Exports;

use App\Models\PeminjamanRuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PeminjamanRuanganExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{

    private $tanggalAwal;
    private $tanggalAkhir;


    public function __construct($tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }



    public function collection()
    {

        $query = PeminjamanRuangan::with([
            'ruangan'
        ]);


        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'tanggal',
                [
                    $this->tanggalAwal,
                    $this->tanggalAkhir
                ]
            );

        }


        return $query->latest()
            ->get()
            ->map(function ($item, $index) {

                return [

                    'No' => $index + 1,

                    'Nama Peminjam' => $item->nama_peminjam ?? '-',

                    'Nama Kegiatan' => $item->nama_kegiatan ?? '-',

                    'Ruangan' => $item->ruangan->nama_ruangan ?? '-',

                    'Tanggal' => $item->tanggal,

                    'Waktu Mulai' => $item->waktu_mulai,

                    'Waktu Selesai' => $item->waktu_selesai,

                ];

            });

    }





    public function headings(): array
    {
        return [

            'No',
            'Nama Peminjam',
            'Nama Kegiatan',
            'Ruangan',
            'Tanggal',
            'Waktu Mulai',
            'Waktu Selesai',

        ];
    }





    public function styles(Worksheet $sheet)
    {

        $lastRow = $sheet->getHighestRow();



        // Header

        $sheet->getStyle('A1:G1')->applyFromArray([

            'font' => [

                'bold' => true,

                'size' => 11,

                'color' => [

                    'rgb' => 'FFFFFF',

                ],

            ],


            'fill' => [

                'fillType' => Fill::FILL_SOLID,

                'startColor' => [

                    'rgb' => '1F4E78',

                ],

            ],


            'alignment' => [

                'horizontal' => 'center',

                'vertical' => 'center',

            ],


            'borders' => [

                'allBorders' => [

                    'borderStyle' => Border::BORDER_THIN,

                ],

            ],

        ]);





        // Border tabel

        $sheet->getStyle("A1:G{$lastRow}")

            ->applyFromArray([

                'borders' => [

                    'allBorders' => [

                        'borderStyle' => Border::BORDER_THIN,

                    ],

                ],

            ]);





        // Center

        $sheet->getStyle("A2:A{$lastRow}")

            ->getAlignment()

            ->setHorizontal('center');


        $sheet->getStyle("E2:G{$lastRow}")

            ->getAlignment()

            ->setHorizontal('center');





        // Vertical

        $sheet->getStyle("A1:G{$lastRow}")

            ->getAlignment()

            ->setVertical('top');





        // Wrap text

        $sheet->getStyle("B2:C{$lastRow}")

            ->getAlignment()

            ->setWrapText(true);





        // Lebar kolom

        $sheet->getColumnDimension('C')

            ->setWidth(35);


        $sheet->getColumnDimension('D')

            ->setWidth(25);





        // Freeze header

        $sheet->freezePane('A2');



        // Filter

        $sheet->setAutoFilter("A1:G{$lastRow}");



        // Tinggi header

        $sheet->getRowDimension(1)

            ->setRowHeight(25);



        return [];

    }

}