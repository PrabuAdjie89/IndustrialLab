<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Barang;

class LaporanController extends Controller
{
    public $pagetitle = 'Stok barang';
    public function index()
    {
        $pagetitle = $this->pagetitle;
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $query = Barang::query();
        if ($search) {
            $query = $query->where('nama_barang','like','%'. $search .'%');
        
        }
        

        $stok = $query->paginate( $perPage )->appends(request()->query());
        confirmDelete('Hapus data ini tidak dapat dibatalkan, lanjutkan?');
        return view("laporan.index", compact('pagetitle', 'stok'));
    }

    /**
     * Get Data 
     */
    public function getData(Request $request)
    {
        $selectedOption = $request->input('opsi');

        if($selectedOption == 'semua'){
             $barangs = Barang::all();
        } elseif ($selectedOption == 'minimum'){
             $barangs = Barang::where('stok', '<=', 10)->get();
        } elseif ($selectedOption == 'stok-habis'){
             $barangs = Barang::where('stok', 0)->get();
        } else {
             $barangs = Barang::all();
        }
 
        return response()->json($barangs);
    }

    /**
     * Print Data 
    */
    public function printStok(Request $request)
    {
        $selectedOption = $request->input('opsi');

        if ($selectedOption == 'semua') {
            $barangs = Barang::all();
        } elseif ($selectedOption == 'minimum') {
            $barangs = Barang::where('stok', '<=', 10)->get();
        } elseif ($selectedOption == 'stok-habis') {
            $barangs = Barang::where('stok', 0)->get();
        } else {
            $barangs = Barang::all();
        }

        // Generate PDF
        $dompdf = new Dompdf();
        $html = view('laporan.print-stok', compact('barangs', 'selectedOption'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('print-stok.pdf', ['Attachment' => false]);
    }
}
