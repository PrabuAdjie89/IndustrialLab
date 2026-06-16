<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BarangKeluarExport implements
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
        $search = request('search');

        $query = BarangKeluar::with('barang');

        if ($this->tanggalAwal && $this->tanggalAkhir) {

            $query->whereBetween(
                'tanggal_keluar',
                [
                    $this->tanggalAwal,
                    $this->tanggalAkhir
                ]
            );

        }

        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                    ->orWhere('kode_barang', 'like', "%$search%");
            });
        }

        return $query->get()->map(function ($item, $index) {
            return [
                'No'               => $index + 1,
                'Kode Barang'      => $item->barang->kode_barang ?? '-',
                'Nama Barang'      => $item->barang->nama_barang ?? '-',
                'Jumlah Keluar'    => $item->jumlah,
                'Tanggal Keluar'   => $item->tanggal_keluar,
                'Keterangan'       => $item->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Jumlah Keluar',
            'Tanggal Keluar',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:F1')->applyFromArray([
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
                'vertical'   => 'center',
            ],

            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->getStyle("A1:F{$lastRow}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F{$lastRow}")->getAlignment()->setVertical('top');
        $sheet->getStyle("F2:F{$lastRow}")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:F{$lastRow}");
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }
}