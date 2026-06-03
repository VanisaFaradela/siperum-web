<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\TipeRumah;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    // Halaman daftar semua cluster
    public function index()
    {
        $clusters = Cluster::where('status', 'aktif')->paginate(9);
        return view('cluster.index', compact('clusters'));
    }
    
    // Halaman detail cluster
    public function show($id)
    {
        // Ambil data cluster berdasarkan cluster_id
        $cluster = Cluster::findOrFail($id);
        
        // Ambil tipe rumah berdasarkan cluster_id
        $tipeRumah = TipeRumah::where('cluster_id', $cluster->cluster_id)->get();
        
        return view('cluster.show', compact('cluster', 'tipeRumah'));
    }
}