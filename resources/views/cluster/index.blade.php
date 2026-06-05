@extends('layouts.app')

@section('title', 'Kategori Cluster - ' . ($cluster->nama_cluster ?? 'Perumahan'))

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #A7E27B 0%, #8fc86a 100%);
        padding: 60px 0;
        text-align: center;
        color: #181E4B;
    }

    .hero-section h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .hero-section p {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .cluster-page-section {
        padding: 60px 0;
    }

    .cluster-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .cluster-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .cluster-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 45px rgba(0,0,0,0.15);
    }

    .cluster-image {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .cluster-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #A7E27B;
        color: #181E4B;
        padding: 5px 15px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 12px;
    }

    .cluster-content {
        padding: 20px;
    }

    .cluster-content h3 {
        font-size: 20px;
        color: #181E4B;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .cluster-location {
        font-size: 13px;
        color: #999;
        margin-bottom: 10px;
    }

    .cluster-location i {
        margin-right: 5px;
        color: #A7E27B;
    }

    .cluster-content p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .cluster-stats {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .cluster-stats span {
        font-size: 12px;
        color: #999;
    }

    .cluster-stats i {
        color: #A7E27B;
        margin-right: 5px;
    }

    .cluster-link {
        display: inline-block;
        margin-top: 15px;
        color: #A7E27B;
        font-weight: 600;
        font-size: 14px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 50px;
        gap: 10px;
    }

    .pagination a, .pagination span {
        display: inline-block;
        padding: 8px 15px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        color: #181E4B;
        text-decoration: none;
    }

    .pagination a:hover {
        background: #A7E27B;
        border-color: #A7E27B;
    }

    .btn-back {
        display: inline-block;
        margin-top: 40px;
        padding: 12px 30px;
        background: transparent;
        border: 2px solid #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
    }

    .btn-back:hover {
        background: #A7E27B;
    }

    @media (max-width: 992px) {
        .cluster-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section h1 { font-size: 32px; }
        .cluster-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container">
            <h1>Kategori Cluster</h1>
            <p>Pilih cluster yang sesuai dengan kebutuhan dan gaya hidup Anda</p>
        </div>
    </section>

    <section class="cluster-page-section">
        <div class="container">
            <div class="cluster-grid">
                @forelse($clusters as $item)
                <a href="{{ route('cluster.show', $item->id_cluster) }}" class="cluster-card">
                    <div class="cluster-image" style="background-image: url('{{ $item->foto_utama ? route('media.cluster', basename($item->foto_utama)) : 'https://via.placeholder.com/400x400?text=Gambar+Tidak+Tersedia' }}');">
                        <div class="cluster-badge">{{ $item->status ?? 'Aktif' }}</div>
                    </div>
                    <div class="cluster-content">
                        <h3>{{ $item->nama_cluster }}</h3>
                        <div class="cluster-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $item->alamat ?? 'Lokasi Strategis' }}
                        </div>
                        <p>{{ Str::limit($item->deskripsi ?? 'Cluster dengan fasilitas lengkap dan lokasi strategis. Nyaman untuk keluarga.', 100) }}</p>
                        <div class="cluster-stats">
                            <span><i class="fas fa-home"></i> {{ $item->total_unit ?? 0 }} Unit</span>
                            <span><i class="fas fa-check-circle"></i> {{ $item->unit_tersedia ?? 0 }} Tersedia</span>
                        </div>
                        <span class="cluster-link">Lihat Detail <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                @empty
                <p style="text-align: center; grid-column: 1/-1; padding: 50px;">Belum ada data cluster.</p>
                @endforelse
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div style="text-align: center;">
            <a href="{{ route('home') }}" class="btn-back">Kembali ke Beranda</a>
        </div>
    </section>
@endsection