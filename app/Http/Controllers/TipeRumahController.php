<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\TipeRumah;

class TipeRumahController extends Controller
{
    public function detail($id)
    {
        $cluster = Cluster::first();
        
        // Ambil data tipe rumah untuk layout
        $tipeRumah = TipeRumah::limit(4)->get();
        view()->share('tipeRumah', $tipeRumah);
        
        $tipe = TipeRumah::findOrFail($id);

        return view('tipe-detail', compact('cluster', 'tipe'));
    }
    private function getImageUrl($path)
    {
        // kosong
        if (!$path) {
            return 'https://via.placeholder.com/800x400?text=No+Image';
        }

        /*
        =========================
        KALAU ARRAY
        =========================
        */
        if (is_array($path)) {

            // ambil item pertama
            $path = $path[0] ?? '';

            // kalau masih array/object
            if (is_array($path) || is_object($path)) {
                return 'https://via.placeholder.com/800x400?text=No+Image';
            }
        }

        /*
        =========================
        PASTIKAN STRING
        =========================
        */
        if (!is_string($path)) {
            $path = (string) $path;
        }

        /*
        =========================
        DECODE JSON HANYA STRING
        =========================
        */
        $decoded = json_decode($path, true);

        if (
            json_last_error() === JSON_ERROR_NONE &&
            is_array($decoded)
        ) {
            $path = $decoded[0] ?? '';
        }

        // rapikan
        $path = trim($path);
        $path = ltrim($path, '/');

        // url langsung
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        /*
        =========================
        CEK FILE
        =========================
        */

        // public/uploads
        if (file_exists(public_path('uploads/' . $path))) {
            return asset('uploads/' . $path);
        }

        // public/storage
        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }

        // public langsung
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return 'https://via.placeholder.com/800x400?text=Image+Not+Found';
    }
}