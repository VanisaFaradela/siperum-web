@extends('layouts.app')

@section('title', 'Tipe ' . ($tipe->nama_tipe ?? 'Rumah') . ' - ' . ($cluster->nama_cluster ?? 'Cluster'))

@push('styles')
<style>
    /* ========== HERO SECTION ========== */
    .hero-section {
        background: linear-gradient(135deg, #A7E27B 0%, #8fc86a 100%);
        padding: 60px 0;
        text-align: center;
        color: #181E4B;
    }

    .hero-section h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 18px;
        opacity: 0.9;
    }

    .detail-section {
        padding: 60px 0;
    }

    .gallery-section {
        margin-bottom: 50px;
    }

    .section-title {
        font-size: 28px;
        color: #181E4B;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #A7E27B;
        display: inline-block;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .gallery-main {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        height: 400px;
    }

    .gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
    }

    .gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .gallery-thumb {
        border-radius: 15px;
        overflow: hidden;
        height: 190px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .gallery-thumb:hover {
        transform: scale(1.02);
    }

    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox img {
        max-width: 95%;
        max-height: 90%;
        border-radius: 15px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-top: 40px;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .info-card h3 {
        font-size: 22px;
        color: #181E4B;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .spec-list {
        list-style: none;
    }

    .spec-list li {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .spec-label {
        font-weight: 600;
        color: #666;
    }

    .spec-value {
        color: #181E4B;
        font-weight: 500;
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
        .gallery-grid,
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="hero-section">
    <div class="container">
        <h1>{{ $tipe->nama_tipe }}</h1>
        <p>
            {{ $cluster->nama_cluster ?? 'Cluster Premium' }}
        </p>
    </div>
</section>

<section class="detail-section">
    <div class="container">

        <div class="gallery-section">

            <h2 class="section-title">
                {{ $tipe->nama_tipe }}
            </h2>

            <div class="gallery-grid">

                <div class="gallery-main">
                    <img
                        id="mainImage"
                        src="{{ route('media.tipe-rumah', basename($tipe->fotoRumahUrl)) }}"
                        alt="{{ $tipe->nama_tipe }}"
                        onclick="openLightbox(this.src)"
                    >
                </div>

                <div class="gallery-thumbs">

                    @foreach($tipe->fotoRumahUrls as $foto)

                    <div class="gallery-thumb"
                        onclick="changeImage('{{ route('media.tipe-rumah', $foto) }}')">

                        <img
                            src="{{ route('media.tipe-rumah', $foto) }}"
                            alt="Foto Rumah">
                    </div>

                    @endforeach

                    @if($tipe->fotoDenahUrl)

                    <div class="gallery-thumb"
                        onclick="changeImage('{{ route('media.tipe-rumah', $tipe->fotoDenahUrl) }}')">

                        <img
                            src="{{ route('media.tipe-rumah', $tipe->fotoDenahUrl) }}"
                            alt="Denah Rumah">

                    </div>

                    @endif

                </div>

            </div>

        </div>

        <div class="lightbox" id="imageLightbox" onclick="closeLightbox(event)">
            <img id="lightboxImage" src="">
        </div>

        <div class="info-grid">

            <div class="info-card">

                <h3>
                    <i class="fas fa-info-circle"></i>
                    Spesifikasi Rumah
                </h3>

                <ul class="spec-list">

                    <li>
                        <span class="spec-label">Cluster</span>
                        <span class="spec-value">
                            {{ $cluster->nama_cluster ?? '-' }}
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Tipe Rumah</span>
                        <span class="spec-value">
                            {{ $tipe->nama_tipe }}
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Luas Tanah</span>
                        <span class="spec-value">
                            {{ number_format($tipe->luas_tanah ?? 0) }} m²
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Luas Bangunan</span>
                        <span class="spec-value">
                            {{ number_format($tipe->luas_bangunan ?? 0) }} m²
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Kamar Tidur</span>
                        <span class="spec-value">
                            {{ $tipe->kamar_tidur ?? 0 }}
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Kamar Mandi</span>
                        <span class="spec-value">
                            {{ $tipe->kamar_mandi ?? 0 }}
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Parkiran</span>
                        <span class="spec-value">
                            {{ $tipe->parkiran ?? 0 }}
                        </span>
                    </li>

                    <li>
                        <span class="spec-label">Harga</span>
                        <span class="spec-value">
                            Rp {{ number_format($tipe->harga ?? 0,0,',','.') }}
                        </span>
                    </li>

                </ul>

            </div>

            <div class="info-card">

                <h3>
                    <i class="fas fa-file-alt"></i>
                    Deskripsi
                </h3>

                <p style="line-height:1.8; color:#666;">
                    {{ $tipe->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>

                <br>

                <h3>
                    <i class="fas fa-check-circle"></i>
                    Status
                </h3>

                <p>

                    @if($tipe->status == 'tersedia')

                        <span style="color:green;">
                            ✓ Tersedia
                        </span>

                    @elseif($tipe->status == 'promo')

                        <span style="color:orange;">
                            ⭐ Promo
                        </span>

                    @else

                        <span style="color:red;">
                            ✗ Habis
                        </span>

                    @endif

                </p>

            </div>

        </div>

        <div style="text-align:center;">
            <a href="{{ route('cluster.show', $tipe->cluster_id) }}" class="btn-back"> Kembali ke {{ $cluster->nama_cluster ?? 'Cluster' }}</a>
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