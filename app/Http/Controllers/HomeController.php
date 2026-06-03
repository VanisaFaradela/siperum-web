<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Page;
use App\Models\TipeRumah;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kontak;
use App\Traits\HasImageUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    use HasImageUrl;
    
    public function index()
    {
        $cluster = Cluster::first();
        
        // Ambil semua data cluster untuk ditampilkan di kategori
        $clusters = Cluster::where('status', 'aktif')->get();
        
        $tipeRumah = TipeRumah::limit(4)->get();
        $page = Page::where('slug', 'tentang-kami')->first();
        
        $berita = Berita::where('status', 'published')
                    ->where(function($query) {
                        $query->whereNull('jenis')
                            ->orWhere('jenis', '!=', 'promo');
                    })
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get();
        
        $galeri = Galeri::where('status', 'aktif')
                    ->orderBy('urutan', 'asc')
                    ->limit(8)
                    ->get();
        
        $kategoriGaleri = DB::table('galeri')
                            ->where('status', 'aktif')
                            ->whereNotNull('kategori')
                            ->distinct()
                            ->pluck('kategori');
        
        $promoBerita = Berita::where('status', 'published')
            ->where('jenis', 'promo')
            ->first();
        
        view()->share('tipeRumah', $tipeRumah);
        view()->share('kategoriGaleri', $kategoriGaleri);
        view()->share('page', $page);
        
        // KALO MAU PAKAI TANGGAL, PAKAI YG INI:
        // $promoBerita = Berita::where('status', 'published')
        //     ->where('jenis', 'promo')
        //     ->where(function($query) {
        //         $query->whereNull('tanggal_mulai_promo')
        //             ->orWhere('tanggal_mulai_promo', '<=', Carbon::today());
        //     })
        //     ->where(function($query) {
        //         $query->whereNull('tanggal_berakhir_promo')
        //             ->orWhere('tanggal_berakhir_promo', '>=', Carbon::today());
        //     })
        //     ->first();
        
        // Bagikan data ke semua view
        view()->share('tipeRumah', $tipeRumah);
        view()->share('kategoriGaleri', $kategoriGaleri);
        view()->share('page', $page);
        
        return view('home', compact('cluster', 'clusters', 'tipeRumah', 'berita', 'galeri', 'promoBerita'));
    }

    public function kontak(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'pesan' => 'required|string',
            'nomor_hp' => 'nullable|string|max:20',
        ]);

        Kontak::create([
            'nama_pengunjung' => $request->nama,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'pesan' => $request->pesan,
            'tanggal_kirim' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim!');
    }

    public function search(Request $request)
    {
        $search = $request->input('cari');
        
        // Pencarian Tipe Rumah
        $tipeRumah = TipeRumah::where('nama_tipe', 'LIKE', "%{$search}%")
            ->orWhere('deskripsi', 'LIKE', "%{$search}%")
            ->get();
        
        // Pencarian Berita
        $berita = Berita::where(function($query) use ($search) {
                $query->where('judul', 'LIKE', "%{$search}%")
                      ->orWhere('konten', 'LIKE', "%{$search}%");
            })
            ->where('status', 'published')
            ->get();

        // Pencarian Cluster
        $clusters = Cluster::where('nama_cluster', 'LIKE', "%{$search}%")
            ->orWhere('deskripsi_cluster', 'LIKE', "%{$search}%")
            ->get();
        
        $cluster = Cluster::first();
        
        return view('search-results', compact('tipeRumah', 'berita', 'clusters', 'search', 'cluster'));
    }
    
    public function tentang()
    {
        $cluster = Cluster::first();
        
        // Ambil data dari tabel pages
        $page = DB::table('pages')
            ->whereIn('slug', ['tentang-kami', 'tentang-siperum'])
            ->orderByRaw("FIELD(slug, 'tentang-kami', 'tentang-siperum')")
            ->first();
        
        // Fallback jika tidak ada data
        if (!$page) {
            $page = (object)[
                'title' => 'Tentang Kami',
                'content' => 'SIPERUM (Sistem Informasi Perumahan) adalah platform digital yang membantu mengelola data perumahan dengan mudah dan efisien.',
                'featured_image' => null,
                'video' => null
            ];
        }

        $page->featured_image_url = self::resolveImageUrl($page->featured_image, 'pages');

        $team = DB::table('team')
            ->when(DB::getSchemaBuilder()->hasColumn('team', 'status'), function ($query) {
                return $query->where('status', 'aktif');
            })
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($member) {
                $member->foto_url = self::resolveImageUrl($member->foto, 'team');
                return $member;
            });
        
        return view('tentang', compact('cluster', 'page', 'team'));
    }

    private function resolvePageImage($featuredImage)
    {
        if (!$featuredImage) {
            return null;
        }

        return self::resolveImageUrl($featuredImage, 'pages');
    }
}