<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Berita;
use App\Models\TipeRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class BeritaController extends Controller
{
    public function index()
    {
        $cluster = Cluster::first();
        
        $tipeRumah = TipeRumah::limit(4)->get();
        view()->share('tipeRumah', $tipeRumah);
        
        $berita = Berita::where('status', 'published')
                       ->orderBy('created_at', 'desc')
                       ->paginate(6);
        
        // Ambil promo dari berita untuk popup
        $promoBerita = Berita::where('status', 'published')
            ->where('jenis', 'promo')
            ->where('popup', 'ya')
            ->where(function($query) {
                $query->whereNull('tanggal_mulai_promo')
                    ->orWhere('tanggal_mulai_promo', '<=', Carbon::today());
            })
            ->where(function($query) {
                $query->whereNull('tanggal_berakhir_promo')
                    ->orWhere('tanggal_berakhir_promo', '>=', Carbon::today());
            })
            ->latest()
            ->first();
        
        return view('berita.index', compact('cluster', 'berita', 'promoBerita'));
    }
    
    public function show($identifier)
    {
        $cluster = Cluster::first();
        
        $tipeRumah = TipeRumah::limit(4)->get();
        view()->share('tipeRumah', $tipeRumah);
        
        $berita = Berita::where('status', 'published')
            ->where(function ($query) use ($identifier) {
                if (is_numeric($identifier)) {
                    $query->where('id', $identifier);
                }
                $query->orWhere('slug', $identifier);
            })
            ->firstOrFail();
        $berita->increment('views');
        
        // Ambil promo dari berita untuk popup
        $promoBerita = Berita::where('status', 'published')
            ->where('jenis', 'promo')
            ->where('popup', 'ya')
            ->where(function($query) {
                $query->whereNull('tanggal_mulai_promo')
                    ->orWhere('tanggal_mulai_promo', '<=', Carbon::today());
            })
            ->where(function($query) {
                $query->whereNull('tanggal_berakhir_promo')
                    ->orWhere('tanggal_berakhir_promo', '>=', Carbon::today());
            })
            ->latest()
            ->first();
        
        return view('berita.show', compact('cluster', 'berita', 'promoBerita'));
    }
    
    public function komentar(Request $request, $id)
    {
        if (!Schema::hasTable('komentar')) {
            return redirect()->back()->with('error', 'Fitur komentar belum tersedia.');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'komentar' => 'required|string',
        ]);
        
        $berita = Berita::findOrFail($id);
    }
}