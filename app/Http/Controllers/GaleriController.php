<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Galeri;
use App\Models\TipeRumah; 
use Illuminate\Support\Facades\DB;

class GaleriController extends Controller
{
    public function index()
    {
        $cluster = Cluster::first();
        
        // Ambil data tipe rumah untuk layout
        $tipeRumah = TipeRumah::limit(4)->get();
        view()->share('tipeRumah', $tipeRumah);
        
        $galeri = Galeri::where('status', 'aktif')
                       ->orderBy('urutan', 'asc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);
        
        // Ambil kategori unik dari database untuk filter
        $kategoriGaleri = DB::table('galeri')
                            ->where('status', 'aktif')
                            ->whereNotNull('kategori')
                            ->distinct()
                            ->pluck('kategori');
        
        return view('galeri.index', compact('cluster', 'galeri', 'kategoriGaleri'));
    }
}