<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use App\Http\Requests\storeRuanganReq;
use App\Http\Requests\updateRuanganReq;

class RuanganController extends Controller
{
    public $pageTitle = "Data Ruangan";

    /**
     * INDEX
     */
    public function index()
    {
        $pageTitle = $this->pageTitle;
        $perPage   = request()->query('perPage') ?? 10;
        $search    = request()->query('search');

        $query = ruangan::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_ruangan', 'like', '%' . $search . '%')
                  ->orWhere('kode_ruangan', 'like', '%' . $search . '%');
            });
        }

        $ruangan = $query
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        confirmDelete('Apakah Anda yakin ingin menghapus data ruangan ini?');

        return view('ruangan.index', compact('pageTitle', 'ruangan'));
    }

    /**
     * STORE
     */
    public function store(storeRuanganReq $request)
    {
        ruangan::create([
            ...$request->validated(),
            'kode_ruangan'   => ruangan::generateKode(),
            'status_ruangan' => 'tersedia',
        ]);

        toast()->success('Ruangan berhasil ditambahkan');

        return redirect()->route('ruangan.index');
    }

    /**
     * UPDATE
     */
    public function update(updateRuanganReq $request, ruangan $ruangan)
    {
        $ruangan->update($request->validated());

        toast()->success('Ruangan berhasil diperbarui');

        return redirect()->route('ruangan.index');
    }

    /**
     * DESTROY
     */
    public function destroy(ruangan $ruangan)
    {
        $ruangan->delete();

        toast()->success('Ruangan berhasil dihapus');

        return redirect()->route('ruangan.index');
    }
}