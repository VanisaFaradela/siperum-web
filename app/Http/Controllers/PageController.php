<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Cluster;
use App\Models\TipeRumah;
use App\Models\Kontak;
use App\Traits\HasImageUrl;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use HasImageUrl;

    // HALAMAN TENTANG
    public function tentang()
    {
        $page = Page::where('slug', 'tentang-kami')->first();

        $cluster = Cluster::first();

        $kontak = Kontak::first();

        if ($page) {
            $page->featured_image_url = $this->resolvePageImage($page->featured_image);
        }

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

        return view('tentang', compact(
            'page',
            'cluster',
            'kontak',
            'team'
        ));
    }

    private function resolvePageImage($featuredImage)
    {
        if (!$featuredImage) {
            return $this->resolvePageFallbackImage();
        }

        return self::resolveImageUrl($featuredImage, 'pages') ?? $this->resolvePageFallbackImage();
    }

    private function resolvePageFallbackImage()
    {
        $fallbacks = glob(public_path('uploads/pages/*')) ?: [];
        if (!empty($fallbacks)) {
            $path = $fallbacks[0];
            $urlPath = str_replace('\\', '/', str_replace(public_path(), '', $path));
            return asset(ltrim($urlPath, '/'));
        }

        return null;
    }

    // HALAMAN KATEGORI
    public function kategori()
    {
        $page = Page::where('slug', 'tentang-kami')->first();

        $cluster = Cluster::first();

        $tipeRumah = TipeRumah::all();

        $kontak = Kontak::first();

        return view('kategori', compact(
            'page',
            'cluster',
            'tipeRumah',
            'kontak'
        ));
    }
}