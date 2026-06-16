<?php

namespace App\View\Components\KategoriBarang;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\KategoriBarang;


class FormKategoriBarang extends Component
{

    public $id, $nama_kategori, $bisa_dipinjam,  $action;
    public function __construct($id = null)
    {
        if($id) {
            $kategori = KategoriBarang::findOrFail( $id );
            $this->id = $kategori->id;
            $this->nama_kategori = $kategori->nama_kategori;
            $this->action = route('master-data.kategori-barang.update', $kategori->id );
        
        
        }
        else {
            $this->action = route('master-data.kategori-barang.store');

        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kategori-barang.form-kategori-barang');
    }
}
