<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $links;

    public function __construct()
    {
        $user = auth()->user();

        $this->links = [

            [
                'label' => 'Dashboard',
                'route' => 'home',
                'is_active' => request()->routeIs('home'),
                'icon' => 'fas fa-chart-line',
                'is_dropdown' => false
            ],


            ...($user && ($user->isLaboran() || $user->isKalab()) ? [[
                'label' => 'Master Data',
                'route' => '#',
                'is_active' => request()->routeIs('master-data.*'),
                'icon' => 'fas fa-cloud',
                'is_dropdown' => true,
                'items' => [
                    [
                        'label' => 'Kategori Barang',
                        'route' => 'master-data.kategori-barang.index',
                    ],
                    [
                        'label' => 'Data Barang',
                        'route' => 'master-data.barang.index',
                    ],
                    [
                        'label' => 'Barang Masuk',
                        'route' => 'master-data.barang-masuk.index',
                    ],
                    [
                        'label' => 'Barang Keluar',
                        'route' => 'master-data.barang-keluar.index',
                    ],
                ]
            ]] : []),

            [
                'label' => 'Peminjaman Barang',
                'route' => 'peminjaman.index',
                'is_active' => request()->routeIs('peminjaman.*'),
                'icon' => 'fas fa-archive',
                'is_dropdown' => false
            ],

  
            [
                'label' => 'Peminjaman Ruang',
                'route' => 'peminjaman-ruang.index',
                'is_active' => request()->routeIs('peminjaman-ruang.*'),
                'icon' => 'fas fa-calendar-check',
                'is_dropdown' => false
            ],

            [
                'label' => 'Monitor Ruangan',
                'route' => 'peminjaman-ruang.monitor',
                'is_active' => request()->routeIs('peminjaman-ruang.monitor.*'),
                'icon' => 'fas fa-tv',
                'is_dropdown' => false
            ],


            ...($user && ($user->isLaboran() || $user->isKalab()) ? [[
                'label' => 'Ruangan',
                'route' => 'ruangan.index',
                'is_active' => request()->routeIs('ruangan.*'),
                'icon' => 'fas fa-building',
                'is_dropdown' => false
            ],

            ] : []),


            // ...($user && ($user->isLaboran() || $user->isKalab()) ? [[
            //     'label' => 'Laporan',
            //     'route' => 'laporan.index',
            //     'is_active' => request()->routeIs('laporan.*'),
            //     'icon' => 'fas fa-clipboard',
            //     'is_dropdown' => false
            // ]] : []),

      
            ...($user && $user->isLaboran() ? [[
                'label' => 'Manajemen User',
                'route' => 'user.index',
                'is_active' => request()->routeIs('user.*'),
                'icon' => 'fas fa-users-cog',
                'is_dropdown' => false
            ],
            [
                'label' => 'Pengaturan SOP',
                'route' => 'settings.sop',
                'is_active' => request()->routeIs('settings.*'),
                'icon' => 'fas fa-file-alt',
                'is_dropdown' => false
            
            ]] : []),

        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}