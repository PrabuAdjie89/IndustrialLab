<?php

namespace App\Http\Controllers;
use App\Http\Requests\updateKategoriBarangRequest;
use App\MOdels\KategoriBarang;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKategoriBarangRequest;




class KategoriBarangController extends Controller
{
    public $pagetitle = 'kategori barang';
    public function index()
    {
        $pagetitle = $this->pagetitle;
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $query = KategoriBarang::query();
        if ($search) {
            $query = $query->where('nama_kategori','like','%'. $search .'%');
        
        }
        

        $kategori = $query->paginate( $perPage )->appends(request()->query());
        confirmDelete('Hapus data ini tidak dapat dibatalkan, lanjutkan?');
        return view("kategori-barang.index", compact('pagetitle', 'kategori'));
    }

    public function store(storeKategoriBarangRequest $request) {
        if(auth()->user()->role == 'kalab'){
            abort(403);
        }
        KategoriBarang::create([
            'nama_kategori'=> $request->nama_kategori
        ]);
        toast()->success('Kategori Barang berhasil ditambahkan');
        return redirect() ->route('master-data.kategori-barang.index');

    }

    public function update(updateKategoriBarangRequest $request, KategoriBarang $kategoriBarang)
    {
        if(auth()->user()->role == 'kalab'){
            abort(403);
        }
        $kategoriBarang->nama_kategori = $request->nama_kategori;
        $kategoriBarang->save();
        toast()->success('Kategori berhasil diubah');
        return redirect()->route('master-data.kategori-barang.index');
    }

    public function destroy(KategoriBarang $kategoriBarang)
    {
        if(auth()->user()->role == 'kalab'){
            abort(403);
        }
        if ($kategoriBarang->barang()->exists()) {

            toast()->error(
                'Kategori tidak dapat dihapus karena masih digunakan oleh data barang.'
            );

            return redirect()->route('master-data.kategori-barang.index');
        }

        $kategoriBarang->delete();

        toast()->success('Kategori berhasil dihapus');

        return redirect()->route('master-data.kategori-barang.index');
    }
}