<?php

namespace App\View\Components\Ruangan;


use Illuminate\View\Component;

class FormRuangan extends Component
{
    public $id, $action;
    public $kode_ruangan, $nama_ruangan, $status_ruangan;

    public function __construct($ruangan = null)
    {
        if ($ruangan) {
            $this->id = $ruangan->id_ruangan;

       
            $this->action = route('ruangan.update', $ruangan);

            $this->kode_ruangan = $ruangan->kode_ruangan;
            $this->nama_ruangan = $ruangan->nama_ruangan;
            $this->status_ruangan = $ruangan->status_ruangan;
        } else {
            $this->id = null;
            $this->action = route('ruangan.store');
        }
    }

    public function render()
    {
        return view('components.ruangan.form-ruangan');
    }
}