@extends('layouts.app')

@section('title', $cluster->nama_cluster . ' - Detail Cluster')

@push('styles')
<style>
    .cluster-hero {
        background: linear-gradient(135deg, #A7E27B 0%, #8fc86a 100%);
        padding: 70px 0;
        text-align: center;
        color: #181E4B;
    }

    .cluster-hero h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .cluster-hero p {
        font-size: 16px;
        opacity: .9;
        margin: 0;
    }

    .cluster-section {
        padding: 60px 0;
        background: #f5f5f5;
        min-height: 100vh;
    }

    .cluster-info {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        margin-bottom: 40px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .cluster-info h3 {
        font-size: 26px;
        font-weight: 800;
        color: #181E4B;
        margin-bottom: 18px;
    }

    .cluster-info p {
        color: #666;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .fasilitas-title {
        font-size: 22px;
        font-weight: 800;
        color: #181E4B;
        margin-top: 25px;
        margin-bottom: 18px;
    }

    .fasilitas-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .fasilitas-item {
        background: #f9f9f9;
        border-radius: 30px;
        padding: 10px 18px;
        font-size: 14px;
        color: #181E4B;
        border: 1px solid #eee;
        font-weight: 500;
        transition: .3s;
    }

    .fasilitas-item:hover {
        background: #A7E27B;
        border-color: #A7E27B;
    }

    .fasilitas-item i {
        color: #7cc94b;
        margin-right: 8px;
    }

    .section-title {
        font-size: 30px;
        font-weight: 800;
        color: #181E4B;
        margin-bottom: 35px;
        text-align: center;
    }

    .tipe-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .tipe-card {
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: .3s ease;
        position: relative;
    }

    .tipe-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.15);
    }

    .tipe-header {
        background: #A7E27B;
        padding: 20px;
        text-align: center;
    }

    .tipe-header h3 {
        font-size: 24px;
        font-weight: 800;
        margin: 0;
        color: #181E4B;
    }

    .unit-info {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .unit-badge {
        background: rgba(24,30,75,0.15);
        color: #181E4B;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: 600;
    }

    .tipe-body {
        padding: 25px;
    }

    .spec-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        color: #555;
        font-size: 15px;
    }

    .spec-item i {
        width: 28px;
        color: #A7E27B;
        font-size: 15px;
    }

    .price {
        font-size: 24px;
        font-weight: 800;
        color: #7cc94b;
        margin-top: 20px;
    }

    .btn-detail {
        display: block;
        width: 100%;
        margin-top: 20px;
        padding: 12px;
        border-radius: 50px;
        background: #A7E27B;
        color: #181E4B;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: .3s;
    }

    .btn-detail:hover {
        background: #181E4B;
        color: #A7E27B;
    }

    .back-wrapper{
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .btn-back {
        padding: 12px 28px;
        border: 2px solid #A7E27B;
        color: #181E4B;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: .3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back:hover {
        background: #A7E27B;
    }

    .empty-data {
        background: #fff;
        border-radius: 20px;
        padding: 50px;
        text-align: center;
        color: #999;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    @media(max-width: 992px) {
        .tipe-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 768px) {
        .cluster-hero h1 {
            font-size: 30px;
        }

        .tipe-grid {
            grid-template-columns: 1fr;
        }

        .cluster-info {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="cluster-hero">
    <div class="container">
        <h1>{{ $cluster->nama_cluster }}</h1>
        <p>{{ $cluster->alamat ?? 'Lokasi belum tersedia' }}</p>
    </div>
</section>

{{-- CONTENT --}}
<section class="cluster-section">
    <div class="container">

        {{-- INFO CLUSTER --}}
        <div class="cluster-info">

            <h3>
                <i class="fas fa-info-circle me-2"></i>
                Tentang Cluster {{ $cluster->nama_cluster }}
            </h3>

            <p>
                {{ $cluster->deskripsi ?? 'Deskripsi belum tersedia.' }}
            </p>

            {{-- FASILITAS --}}
            @if($cluster->fasilitas)

            <div class="fasilitas-title">
                <i class="fas fa-check-circle me-2"></i>
                Fasilitas
            </div>

            <div class="fasilitas-list">

                @php
                    $fasilitas = json_decode($cluster->fasilitas, true);
                @endphp

                @if($fasilitas)
                    @foreach($fasilitas as $item)
                        <div class="fasilitas-item">
                            <i class="fas fa-check"></i>
                            {{ $item }}
                        </div>
                    @endforeach
                @endif

            </div>

            @endif

        </div>

        {{-- TIPE RUMAH --}}
        <h2 class="section-title">
            Tipe Rumah Tersedia di Cluster {{ $cluster->nama_cluster }}
        </h2>

        @if($cluster->tipeRumah && $cluster->tipeRumah->count() > 0)

        <div class="tipe-grid">

            @foreach($cluster->tipeRumah as $item)

            <div class="tipe-card">

                {{-- HEADER --}}
                <div class="tipe-header">

                    <h3>{{ $item->nama_tipe }}</h3>

                    @if($item->blok || $item->nomor_unit)

                    <div class="unit-info">

                        @if($item->blok)
                        <span class="unit-badge">
                            <i class="fas fa-home"></i>
                            Blok {{ $item->blok }}
                        </span>
                        @endif

                        @if($item->nomor_unit)
                        <span class="unit-badge">
                            <i class="fas fa-map-marker-alt"></i>
                            Unit {{ $item->nomor_unit }}
                        </span>
                        @endif

                    </div>

                    @endif

                </div>

                {{-- BODY --}}
                <div class="tipe-body">

                    <div class="spec-item">
                        <i class="fas fa-expand"></i>
                        Luas Tanah : {{ number_format($item->luas_tanah) }} m²
                    </div>

                    <div class="spec-item">
                        <i class="fas fa-building"></i>
                        Luas Bangunan : {{ number_format($item->luas_bangunan) }} m²
                    </div>

                    <div class="spec-item">
                        <i class="fas fa-bed"></i>
                        Kamar Tidur : {{ $item->kamar_tidur }}
                    </div>

                    <div class="spec-item">
                        <i class="fas fa-bath"></i>
                        Kamar Mandi : {{ $item->kamar_mandi }}
                    </div>

                    <div class="spec-item">
                        <i class="fas fa-car"></i>
                        Parkiran : {{ $item->parkiran }} Mobil
                    </div>

                    <div class="price">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </div>

                    <a href="{{ route('tipe-detail', $item->id_tipe) }}" class="btn-detail">Lihat Detail → </a>

                </div>

            </div>

            @endforeach

        </div>

        @else

        <div class="empty-data">
            <h4>Belum ada tipe rumah</h4>
            <p>
                Belum tersedia data tipe rumah untuk cluster
                {{ $cluster->nama_cluster }}
            </p>
        </div>

        @endif

        <div class="back-wrapper">
            <a href="{{ route('cluster.index') }}" class="btn-back"> Kembali ke Daftar Cluster </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}

function openLightbox(src) {
    document.getElementById('lightboxImage').src = src;
    document.getElementById('imageLightbox').classList.add('active');
}

function closeLightbox(event) {
    if(event.target.id === 'imageLightbox') {
        document.getElementById('imageLightbox').classList.remove('active');
    }
}
</script>
@endpush