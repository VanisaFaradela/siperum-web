@extends('layouts.app')

@section('title', $page->title ?? 'Tentang Kami - ' . ($cluster->nama_cluster ?? 'Cluster'))

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

    .about-page-section {
        padding: 60px 0;
    }

    .logo-section {
        text-align: center;
        margin-bottom: 60px;
        padding: 40px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .logo-img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        margin-bottom: 20px;
    }

    .logo-section h2 {
        font-size: 32px;
        color: #181E4B;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .logo-section .slogan {
        font-size: 18px;
        color: #A7E27B;
        margin-bottom: 20px;
    }

    .deskripsi-section {
        margin-bottom: 60px;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 20px;
    }

    .deskripsi-section h3 {
        font-size: 28px;
        color: #181E4B;
        margin-bottom: 20px;
        font-weight: 700;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }

    .deskripsi-section h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #A7E27B;
    }

    .deskripsi-section p {
        color: #666;
        line-height: 1.8;
        font-size: 16px;
        margin-top: 20px;
        white-space: pre-line;
    }

    .team-section {
        margin-bottom: 60px;
    }

    .team-section h3 {
        font-size: 28px;
        color: #181E4B;
        margin-bottom: 40px;
        font-weight: 700;
        text-align: center;
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .team-section h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #A7E27B;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .team-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        text-align: center;
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .team-photo {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }

    .team-info {
        padding: 20px;
    }

    .team-info h4 {
        font-size: 20px;
        color: #181E4B;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .team-info .jabatan {
        color: #A7E27B;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .team-info .bio {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }

    .kontak-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-top: 40px;
    }

    .kontak-card, .medsos-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .kontak-card h3, .medsos-card h3 {
        font-size: 24px;
        color: #181E4B;
        margin-bottom: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kontak-card h3 i, .medsos-card h3 i {
        color: #A7E27B;
    }

    .kontak-list {
        list-style: none;
    }

    .kontak-list li {
        padding: 12px 0;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .kontak-list li:last-child {
        border-bottom: none;
    }

    .kontak-list li i {
        width: 35px;
        height: 35px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A7E27B;
        font-size: 16px;
    }

    .kontak-list li span {
        color: #666;
        font-size: 15px;
    }

    .medsos-grid {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .medsos-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        background: #f8f9fa;
        border-radius: 50px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .medsos-item:hover {
        background: #A7E27B;
        transform: translateY(-3px);
    }

    .medsos-icon {
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A7E27B;
        font-size: 18px;
    }

    .map-section {
        margin-top: 40px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .map-section iframe {
        width: 100%;
        height: 350px;
        border: none;
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
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #A7E27B;
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="container">
        <h1>{{ $page->title ?? 'Tentang Kami' }}</h1>
        <p>Mengenal lebih dekat cluster kami</p>
    </div>
</section>

<section class="about-page-section">
    <div class="container">

        <!-- LOGO -->
        <div class="logo-section">
            @if($cluster && $cluster->logo_url)
                <img src="{{ $cluster->logo_url }}" alt="Logo" class="logo-img">
            @else
                <div class="logo-img" style="background:#A7E27B;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:auto;">
                    <i class="fas fa-home" style="font-size:60px;color:#181E4B;"></i>
                </div>
            @endif

            <h2>{{ $cluster->nama_cluster ?? 'Cluster Modern' }}</h2>

            <div class="slogan">
                {{ $cluster->slogan ?? 'Hunian Nyaman dan Modern' }}
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div class="deskripsi-section">
            <h3>{{ $page->title ?? 'Tentang Kami' }}</h3>

            <p>
                {!! nl2br($page->content ?? '') !!}
            </p>

            @if(!empty($page->featured_image_url))
            <div style="margin-top:30px;">
                <img 
                    src="{{ $page->featured_image_url }}"
                    alt="{{ $page->title }}"
                    style="width:100%; border-radius:20px;"
                >
            </div>
            @endif

            @if(isset($page->video) && $page->video)
            <div style="margin-top:30px;">
                @php
                    $videoUrl = $page->video;

                    if (strpos($videoUrl, 'youtu.be') !== false) {
                        $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                        $videoId = explode('?', $videoId)[0];
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    } else {
                        $embedUrl = $videoUrl;
                    }
                @endphp

                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:20px;">
                    <iframe 
                        src="{{ $embedUrl }}"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            @endif
        </div>

        <!-- TEAM -->
        <div class="team-section">
            <h3>Tim Manajemen</h3>

            <div class="team-grid">
                @forelse($team as $member)
                <div class="team-card">
                    <img 
                        src="{{ $member->foto_url ?? 'https://via.placeholder.com/400x400' }}"
                        alt="{{ $member->nama }}"
                        class="team-photo"
                    >

                    <div class="team-info">
                        <h4>{{ $member->nama }}</h4>

                        <div class="jabatan">
                            {{ $member->jabatan }}
                        </div>

                        <p class="bio">
                            {{ $member->deskripsi ?? $member->bio }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="team-card">
                    <div class="team-info">
                        <h4>Belum ada data tim</h4>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- KONTAK -->
        <div class="kontak-section">

            <div class="kontak-card">
                <h3>
                    <i class="fas fa-address-card"></i>
                    Kontak Kami
                </h3>

                <ul class="kontak-list">

                    @if($kontak && $kontak->alamat)
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $kontak->alamat }}</span>
                    </li>
                    @endif

                    @if($kontak && $kontak->telepon)
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>{{ $kontak->telepon }}</span>
                    </li>
                    @endif

                    @if($kontak && $kontak->email)
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>{{ $kontak->email }}</span>
                    </li>
                    @endif

                    @if($kontak && $kontak->jam_operasional)
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>{{ $kontak->jam_operasional }}</span>
                    </li>
                    @endif

                </ul>
            </div>

            <!-- MEDSOS -->
            <div class="medsos-card">
                <h3>
                    <i class="fas fa-share-alt"></i>
                    Media Sosial
                </h3>

                <div class="medsos-grid">

                    @if($kontak && $kontak->facebook)
                    <a href="{{ $kontak->facebook }}" target="_blank" class="medsos-item">
                        <div class="medsos-icon">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <span>Facebook</span>
                    </a>
                    @endif

                    @if($kontak && $kontak->instagram)
                    <a href="{{ $kontak->instagram }}" target="_blank" class="medsos-item">
                        <div class="medsos-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <span>Instagram</span>
                    </a>
                    @endif

                    @if($kontak && $kontak->youtube)
                    <a href="{{ $kontak->youtube }}" target="_blank" class="medsos-item">
                        <div class="medsos-icon">
                            <i class="fab fa-youtube"></i>
                        </div>
                        <span>YouTube</span>
                    </a>
                    @endif

                </div>
            </div>

        </div>

        <!-- MAP -->
        <div class="map-section">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18"
                allowfullscreen
                loading="lazy">
            </iframe>
        </div>

        <div style="text-align:center;">
            <a href="{{ route('home') }}" class="btn-back"> Kembali ke Beranda</a>
        </div>

    </div>
</section>
@endsection