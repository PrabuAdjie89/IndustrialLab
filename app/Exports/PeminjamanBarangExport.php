<?php

namespace App\Exports;

use App\Models\PeminjamanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PeminjamanBarangExport implements
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
        $query = PeminjamanBarang::with([
            'detailPeminjaman.barang'
        ]);


        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'tanggal_pinjam',
                [
                    $this->tanggalAwal,
                    $this->tanggalAkhir
                ]
            );

        }



        $data = collect();
        $no = 1;



        foreach ($query->get() as $pinjam) {


            foreach ($pinjam->detailPeminjaman as $detail) {


                $data->push([

                    'No' => $no++,

                    'Kode Peminjaman' => $pinjam->kode_peminjaman,

                    'Unit Peminjaman' => $pinjam->unit_peminjam,

                    'Nomor Telepon' => $pinjam->nomor_telepon,

                    'Nama Barang' => $detail->barang->nama_barang ?? '-',

                    'Jumlah' => $detail->jumlah,

                    'Tanggal Pinjam' => $pinjam->tanggal_pinjam,

                    'Tanggal Kembali' => $pinjam->tanggal_kembali,

                ]);

            }

        }


        return $data;
    }





    public function headings(): array
    {
        return [

            'No',
            'Kode Peminjaman',
            'Unit Peminjaman',
            'Nomor Telepon',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',

        ];
    }





    public function styles(Worksheet $sheet)
    {

        $lastRow = $sheet->getHighestRow();



        // Header Style

        $sheet->getStyle('A1:H1')->applyFromArray([

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





        // Border semua tabel

        $sheet->getStyle("A1:H{$lastRow}")

            ->applyFromArray([

                'borders' => [

                    'allBorders' => [

                        'borderStyle' => Border::BORDER_THIN,

                    ],

                ],

            ]);





        // Alignment

        $sheet->getStyle("A2:A{$lastRow}")

            ->getAlignment()

            ->setHorizontal('center');



        $sheet->getStyle("F2:F{$lastRow}")

            ->getAlignment()

            ->setHorizontal('center');



        $sheet->getStyle("G2:H{$lastRow}")

            ->getAlignment()

            ->setHorizontal('center');





        // Vertical top

        $sheet->getStyle("A1:H{$lastRow}")

            ->getAlignment()

            ->setVertical('top');





        // Wrap text nama barang

        $sheet->getStyle("E2:E{$lastRow}")

            ->getAlignment()

            ->setWrapText(true);



        // Ukuran kolom barang

        $sheet->getColumnDimension('E')

            ->setWidth(35);



        // Freeze header

        $sheet->freezePane('A2');



        // Filter

        $sheet->setAutoFilter("A1:H{$lastRow}");



        // Tinggi header

        $sheet->getRowDimension(1)

            ->setRowHeight(25);



        return [];

    }

}