@extends('layouts.app')

@section('title', 'Homepage - ' . ($cluster->nama_cluster ?? 'cluster'))

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
    .hero-slider {
        width: 100%;
        height: 500px;
        position: relative;
        overflow: hidden;
    }

    .hero-slider .swiper {
        width: 100%;
        height: 100%;
    }

    .hero-slider .swiper-slide {
        position: relative;
        background-size: cover;
        background-position: center;
        border-radius: 0;
        overflow: hidden;
    }

    .hero-slider .swiper-slide::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 1;
    }

    .hero-slider .slide-content {
        position: absolute;
        bottom: 80px;
        left: 80px;
        z-index: 2;
        color: white;
        text-align: left;
        max-width: 600px;
    }

    .hero-slider .slide-content h1 {
        font-size: 56px;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 15px;
    }

    .hero-slider .slide-content p {
        font-size: 20px;
        opacity: 0.95;
    }

    .hero-slider .swiper-pagination {
        bottom: 30px !important;
    }

    .hero-slider .swiper-pagination-bullet {
        width: 35px;
        height: 5px;
        border-radius: 20px;
        background: rgba(255,255,255,0.4);
        transition: all 0.3s ease;
    }

    .hero-slider .swiper-pagination-bullet-active {
        background: #A7E27B;
        width: 45px;
    }

    .hero-slider .swiper-button-next,
    .hero-slider .swiper-button-prev {
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        width: 55px;
        height: 55px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        transition: 0.3s;
    }

    .hero-slider .swiper-button-next::after,
    .hero-slider .swiper-button-prev::after {
        display: none;
    }

    .hero-slider .swiper-button-next i,
    .hero-slider .swiper-button-prev i {
        font-size: 18px;
    }

    .hero-slider .swiper-button-next:hover,
    .hero-slider .swiper-button-prev:hover {
        background: rgba(255,255,255,0.3);
    }

    @media (max-width: 768px) {
        .hero-slider { height: 350px; }
        .hero-slider .slide-content { left: 25px; bottom: 60px; right: 20px; }
        .hero-slider .slide-content h1 { font-size: 30px; }
        .hero-slider .slide-content p { font-size: 16px; }
        .hero-slider .swiper-button-next,
        .hero-slider .swiper-button-prev { width: 40px; height: 40px; }
    }

    /* POPUP CARD STYLES */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .popup-overlay.active {
        visibility: visible;
        opacity: 1;
    }

    .popup-card {
        position: relative;
        width: 90%;
        max-width: 380px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }

    .popup-overlay.active .popup-card {
        transform: scale(1);
    }

    .popup-card-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .popup-card-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #dc3545;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .popup-card-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        color: #333;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .popup-card-close:hover {
        background: #dc3545;
        color: white;
        transform: scale(1.05);
    }

    .popup-card-content {
        padding: 20px;
    }

    .popup-card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #1a1a1a;
    }

    .popup-card-location {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .popup-card-location i {
        margin-right: 5px;
    }

    .popup-card-price {
        font-size: 24px;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 15px;
    }

    .popup-card-oldprice {
        font-size: 14px;
        color: #999;
        text-decoration: line-through;
        margin-left: 10px;
        font-weight: normal;
    }

    .popup-card-desc {
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .popup-card-btn {
        display: block;
        width: 100%;
        background: #28a745;
        color: white;
        text-align: center;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .popup-card-btn:hover {
        background: #1e7e34;
        color: white;
    }

    .search-section {
        background: white;
        padding: 50px 0;
        text-align: center;
    }

    .search-form {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        gap: 15px;
    }

    .search-input {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 50px;
        font-size: 16px;
    }

    .search-btn {
        padding: 15px 30px;
        background: #A7E27B;
        color: #181E4B;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
    }

    .about-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .about-content h2 {
        font-size: 36px;
        color: #181E4B;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .about-content p {
        color: #666;
        margin-bottom: 30px;
        line-height: 1.8;
    }

    .btn-view-all-header {
        display: inline-block;
        padding: 8px 22px;
        background: transparent;
        border: 2px solid #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-view-all-header:hover {
        background: #A7E27B;
        color: #181E4B;
    }

    .about-video iframe {
        width: 100%;
        height: 350px;
        border-radius: 20px;
    }

    /* KATEGORI SECTION */
    .categories-section {
        padding: 80px 0;
        background: white;
        position: relative;
    }

    .section-title {
        text-align: center;
        font-size: 36px;
        color: #181E4B;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .section-subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 50px;
        font-size: 18px;
    }

    /* Kategori Slider Container */
    .kategori-slider-container {
        position: relative;
    }

    .categories-grid {
        display: flex;
        gap: 25px;
        overflow-x: auto;
        overflow-y: visible;
        align-items: flex-start;
        scroll-behavior: smooth;
        padding-bottom: 15px;
        scrollbar-width: none;
    }

    .categories-grid::-webkit-scrollbar {
        display: none;
    }

    .category-card {
        min-width: 280px;
        width: 280px;
        background: #A7E27B;
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.45s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: auto;
        min-height: 280px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 3px dotted rgba(255,255,255,0.7);
    }

    .category-card:hover {
        transform: scale(1.005);
        box-shadow: 0 16px 32px rgba(0,0,0,0.12);
        z-index: 1101;
        background: #A7E27B;
        border: 3px solid rgba(255,255,255,0.9);
    }

    .category-card:hover .category-icon {
        transform: translateY(4px);
        transition: transform 0.45s ease;
    }

    .category-card:hover h3 {
        transform: translateY(-8px);
        transition: transform 0.45s ease;
    }

    .category-card:hover p {
        color: #2c3e50;
    }

    .category-card:hover .category-link {
        background: rgba(255,255,255,0.92);
        color: #181E4B;
        transform: translateX(0);
        box-shadow: inset 0 0 0 1px rgba(24,30,75,0.08);
    }

    .category-icon {
        font-size: 50px;
        color: #181E4B;
        margin-bottom: 20px;
    }

    .category-card h3 {
        font-size: 22px;
        color: #181E4B;
        margin-bottom: 12px;
        font-weight: 700;
        line-height: 1.3;
    }

    .category-card p {
        color: #2c3e50;
        line-height: 1.5;
        font-size: 13px;
        flex-grow: 1;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-link {
        display: inline-block;
        margin-top: auto;
        color: #181E4B;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 20px;
        background: rgba(255,255,255,0.3);
        border-radius: 30px;
        transition: all 0.3s ease;
        width: fit-content;
        align-self: center;
    }

    .category-link:hover {
        background: rgba(255,255,255,0.5);
        transform: translateX(3px);
    }

    .kategori-slider-container {
        position: relative;
        overflow: visible;
    }

    .categories-grid {
        padding-bottom: 20px;
    }

    /* Pastikan hover tidak terpotong - handled by container and z-index */

    /* Tombol Navigasi Bawah - Tengah */
    .kategori-nav-bottom {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .kategori-nav-bottom button {
        width: 45px;
        height: 45px;
        border: none;
        background: #181E4B;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kategori-nav-bottom button:hover {
        background: #A7E27B;
        color: #181E4B;
        transform: scale(1.05);
    }

        @media (max-width: 768px) {
        .category-card {
            min-width: 240px;
            padding: 20px;
        }
        
        .category-card h3 {
            font-size: 18px;
        }
        
        .kategori-nav-bottom button {
            width: 38px;
            height: 38px;
            font-size: 14px;
        }
    }

    .berita-section {
        padding: 80px 0;
        background: white;
    }

    .berita-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
    }

    .berita-header .btn-view-all-header {
        position: absolute;
        top: 0;
        right: 0;
        padding: 12px 35px;
        background: transparent;
        border: 2px solid #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-view-all-header:hover {
        background: #A7E27B;
    }

    .berita-header h2 {
        font-size: 36px;
        color: #181E4B;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .berita-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .berita-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }

    .berita-card:hover {
        transform: translateY(-10px);
    }

    .berita-image {
        height: 200px;
        background-size: cover;
        background-position: center;
    }

    .berita-date {
        padding: 12px 20px 0;
        color: #A7E27B;
        font-size: 12px;
        font-weight: 600;
    }

    .berita-content {
        padding: 0 20px 20px;
    }

    .berita-content h3 {
        font-size: 18px;
        color: #181E4B;
        margin-bottom: 10px;
    }

    .berita-content p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .berita-link {
        color: #A7E27B;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .galeri-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .galeri-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .galeri-header h2 {
        font-size: 36px;
        color: #181E4B;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .galeri-filter {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 25px;
        background: white;
        border: 2px solid #A7E27B;
        color: #181E4B;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #A7E27B;
        color: #181E4B;
    }

    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .galeri-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        aspect-ratio: 1 / 1;
        transition: all 0.3s;
    }

    .galeri-item:hover {
        transform: translateY(-10px);
    }

    .galeri-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .galeri-overlay {
        position: absolute;
        bottom: -100%;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        transition: bottom 0.3s;
    }

    .galeri-item:hover .galeri-overlay {
        bottom: 0;
    }

    .view-all {
        text-align: center;
        margin-top: 50px;
    }

    .btn-view-all {
        display: inline-block;
        padding: 12px 35px;
        background: transparent;
        border: 2px solid #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-view-all:hover {
        background: #A7E27B;
    }

    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 99999;
        cursor: pointer;
        align-items: center;
        justify-content: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        cursor: default;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 40px;
        cursor: pointer;
        z-index: 99999;
        transition: all 0.3s;
    }

    .lightbox-close:hover {
        color: #A7E27B;
        transform: scale(1.1);
    }

    @media (max-width: 992px) {
        .berita-grid { grid-template-columns: repeat(2, 1fr); }
        .galeri-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .about-grid { grid-template-columns: 1fr; }
        .berita-grid { grid-template-columns: 1fr; }
        .galeri-grid { grid-template-columns: 1fr; }
        .berita-header .btn-view-all-header { position: static; margin-top: 15px; display: inline-block; }
        .search-form { flex-direction: column; }
    }
        
    /* ========== SCROLL TRANSITION EFFECTS ========== */
    /* Smooth scrolling untuk seluruh halaman */
    html {
        scroll-behavior: smooth;
    }

    /* Efek fade-in saat elemen muncul saat di-scroll */
    .fade-up {
        opacity: 1;
        transform: translateY(0);
    }
    
    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Efek fade-in dari kiri */
    .fade-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-left.visible {
        opacity: 1;
        transform: translateX(0);
    }

    /* Efek fade-in dari kanan */
    .fade-right {
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-right.visible {
        opacity: 1;
        transform: translateX(0);
    }

    /* Efek zoom-in */
    .zoom-in {
        opacity: 0;
        transform: scale(0.9);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .zoom-in.visible {
        opacity: 1;
        transform: scale(1);
    }

    .category-card, .berita-card, .galeri-item {
        opacity: 1;
        transform: translateY(0);
    }
    
    .category-card.visible, .berita-card.visible, .galeri-item.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Stagger delay untuk kartu (muncul satu per satu) */
    .category-card:nth-child(1) { transition-delay: 0.1s; }
    .category-card:nth-child(2) { transition-delay: 0.2s; }
    .category-card:nth-child(3) { transition-delay: 0.3s; }
    .category-card:nth-child(4) { transition-delay: 0.4s; }

    .berita-card:nth-child(1) { transition-delay: 0.1s; }
    .berita-card:nth-child(2) { transition-delay: 0.2s; }
    .berita-card:nth-child(3) { transition-delay: 0.3s; }

    .galeri-item:nth-child(1) { transition-delay: 0.05s; }
    .galeri-item:nth-child(2) { transition-delay: 0.1s; }
    .galeri-item:nth-child(3) { transition-delay: 0.15s; }
    .galeri-item:nth-child(4) { transition-delay: 0.2s; }
    .galeri-item:nth-child(5) { transition-delay: 0.25s; }
    .galeri-item:nth-child(6) { transition-delay: 0.3s; }
    .galeri-item:nth-child(7) { transition-delay: 0.35s; }
    .galeri-item:nth-child(8) { transition-delay: 0.4s; }

    /* Scroll progress bar */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #A7E27B, #181E4B);
        z-index: 10000;
        transition: width 0.1s ease-out;
        box-shadow: 0 0 10px rgba(167, 226, 123, 0.5);
    }

    /* Efek header shadow saat di-scroll */
    .header.scrolled {
        box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        padding: 15px 0;
        transition: all 0.3s ease;
    }
</style>
@endpush

@section('content')
    <!-- SLIDER HERO -->
    <section class="hero-slider" id="home">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&w=1920&h=500&fit=crop');">
                    <div class="slide-content">
                        <h1>Temukan Rumah Impian Anda</h1>
                        <p>Pilihan banyak tipe rumah yang sesuai dengan kebutuhan Anda</p>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&w=1920&h=500&fit=crop');">
                    <div class="slide-content">
                        <h1>Hunian Nyaman untuk Keluarga</h1>
                        <p>Dengan desain modern dan fasilitas lengkap</p>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1448630360428-65456885c650?ixlib=rb-4.0.3&w=1920&h=500&fit=crop');">
                    <div class="slide-content">
                        <h1>Lokasi Strategis & Premium</h1>
                        <p>Akses mudah ke pusat kota dan fasilitas umum</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- ========== POPUP CARD ========== -->
    @if(isset($promoBerita) && $promoBerita)
    <div id="promoPopup" class="popup-overlay">
        <div class="popup-card">
            <div class="popup-card-close" onclick="closePopup()">&times;</div>
            <img src="{{ $promoBerita->gambar ? route('media.berita', $promoBerita->gambar) : 'https://placehold.co/400x220/28a745/white?text=PROMO' }}"
                class="popup-card-img"
                alt="{{ $promoBerita->judul ?? 'Promo' }}">
            <div class="popup-card-badge">
                <i class="fas fa-fire"></i> PROMO TERBATAS!
            </div>
            <div class="popup-card-content">
                <div class="popup-card-title">{{ Str::limit($promoBerita->judul, 50) }}</div>
                <div class="popup-card-location">
                    <i class="fas fa-map-marker-alt"></i> {{ $cluster->nama_cluster ?? 'Perumahan Idaman' }}
                </div>
                <div class="popup-card-price">
                    Hemat Diskon!
                    @if($promoBerita->harga_promo)
                        <span class="popup-card-oldprice">Rp {{ number_format($promoBerita->harga, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="popup-card-desc">
                    {{ Str::limit(strip_tags($promoBerita->konten), 80) }}
                </div>
                <a href="{{ route('berita.show', $promoBerita->slug ?? $promoBerita->id_berita) }}" class="popup-card-btn">
                    Cek Selengkapnya →
                </a>
            </div>
        </div>
    </div>

    <script>
        function closePopup() {
            document.getElementById('promoPopup').classList.remove('active');
            fetch('{{ route("promo.modal.seen") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).catch(err => console.log(err));
        }

        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('promoPopup').classList.add('active');
            }, 500);
        });

        document.getElementById('promoPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });
    </script>
    @endif

    <!-- SEARCH SECTION -->
    <section class="search-section fade-up">
        <div class="container">
            <form class="search-form" action="{{ route('search') }}" method="GET">
                <input type="text" name="cari" class="search-input" placeholder="Search" required>
                <button type="submit" class="search-btn">Cari Kebutuhan Anda</button>
            </form>
        </div>
    </section>

    <!-- TENTANG KAMI SECTION -->
    <section class="about-section fade-up" id="tentang">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h2>Tentang Kami</h2>
                    <p>{{ Str::limit(strip_tags($page->content ?? 'Deskripsi belum tersedia'), 250) }}</p>
                    <a href="{{ route('tentang') }}" class="btn-view-all-header">Tentang Kami</a>
                </div>
                <div class="about-video">
                    @php
                        $youtube = $page->video ?? '';
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $youtube, $matches);
                        $youtubeId = $matches[1] ?? null;
                    @endphp
                    @if($youtubeId)
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <div style="background: #e9ecef; height: 350px; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                            <i class="fas fa-play-circle fa-4x text-secondary"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- KATEGORI SECTION (MENAMPILKAN CLUSTER) -->
    <section class="categories-section fade-up" id="kategori">
        <div class="container">
            <h2 class="section-title">Kategori Cluster</h2>
            <p class="section-subtitle">Pilih cluster yang sesuai dengan kebutuhan Anda</p>

            <div class="kategori-slider-container">
                <div class="categories-grid" id="kategoriSlider">
                    @forelse($clusters as $clusterItem)
                    <div class="category-card">
                        <div class="category-icon">
                            @if($clusterItem->logo)
                                <img src="{{ asset($clusterItem->logo) }}"
                                    alt="{{ $clusterItem->nama_cluster }}"
                                    width="40"
                                    height="40"
                                    style="object-fit:cover; border-radius:50%;">
                            @else
                                <i class="fas fa-building"></i>
                            @endif
                        </div>
                        <h3>{{ $clusterItem->nama_cluster }}</h3>
                        <p>{{ Str::limit($clusterItem->deskripsi ?? 'Cluster dengan fasilitas lengkap dan lokasi strategis. Nyaman untuk keluarga.', 100) }}</p>
                        <a href="{{ route('cluster.show', $clusterItem->id_cluster) }}" class="category-link">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @empty
                    <p style="text-align:center; width:100%; padding:50px;">Belum ada data cluster.</p>
                    @endforelse
                </div>
            </div>

            <!-- Tombol Navigasi di Bawah Tengah -->
            <div class="kategori-nav-bottom">
                <button class="kategori-prev-bottom">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="kategori-next-bottom">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- BERITA SECTION -->
    <section class="berita-section fade-up" id="berita">
        <div class="container">
            <div class="berita-header">
                <div class="view-all">
                    <a href="{{ route('berita.index') }}" class="btn-view-all-header">Lihat Semua Berita</a>
                </div>
                <h2>Berita & Artikel</h2>
                <p>Informasi terbaru seputar properti dan perumahan</p>
            </div>
            <div class="berita-grid">
                @forelse($berita as $item)
                <div class="berita-card">
                    <div class="berita-image" style="background-image: url('{{ $item->gambar ? route('media.berita', $item->gambar) : 'https://via.placeholder.com/400x220?text=Gambar+Berita+Tidak+Tersedia' }}');"></div>
                    <div class="berita-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</div>
                    <div class="berita-content">
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ Str::limit($item->konten, 100) }}</p>
                        <a href="{{ route('berita.show', $item->slug) }}" class="berita-link">Baca Selengkapnya →</a>
                    </div>
                </div>
                @empty
                <p style="text-align: center;">Belum ada berita.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- GALERI SECTION -->
    <section class="galeri-section fade-up" id="galeri">
        <div class="container">
            <div class="galeri-header">
                <h2>Galeri</h2>
                <p>Galeri foto properti dan perumahan</p>
            </div>
            <div class="galeri-filter">
                <button class="filter-btn active" data-filter="all">Semua</button>
                @foreach($kategoriGaleri as $kategori)
                    <button class="filter-btn" data-filter="{{ strtolower($kategori) }}">{{ ucfirst($kategori) }}</button>
                @endforeach
            </div>
            <div class="galeri-grid" id="galeriGrid">
                @forelse($galeri as $item)
                <div class="galeri-item" data-category="{{ $item->kategori_foto ?? 'umum' }}" style="cursor: pointer;">
                    <img src="{{ $item->foto ? route('media.galeri', $item->foto) : 'https://via.placeholder.com/400x400?text=Gambar+Tidak+Tersedia' }}" alt="{{ $item->judul_galeri }}">
                    <div class="galeri-overlay">
                        <i class="fas fa-search-plus"></i>
                        <h4>{{ $item->judul_galeri }}</h4>
                        <p>{{ $item->kategori_foto ?? 'Foto' }}</p>
                    </div>
                </div>
                @empty
                <p style="text-align: center;">Belum ada data galeri.</p>
                @endforelse
            </div>
            <div class="view-all">
                <a href="{{ route('galeri.index') }}" class="btn-view-all">Lihat Semua Galeri</a>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox">
        <span class="lightbox-close">&times;</span>
        <img id="lightboxImg" src="">
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    // Swiper Hero
    document.addEventListener('DOMContentLoaded', function () {

        var swiper = new Swiper(".mySwiper", {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            }
        });

    });

    // Galeri Filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galeriItems = document.querySelectorAll('.galeri-item');

    if (filterBtns.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filterValue = this.getAttribute('data-filter');
                galeriItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // ========== PERBAIKAN TOTAL UNTUK GALERI ==========
    // Ambil elemen lightbox
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxClose = document.querySelector('.lightbox-close');

    // Fungsi buka lightbox
    function bukaLightbox(src) {
        if (lightboxImg && lightbox) {
            lightboxImg.src = src;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    // Fungsi tutup lightbox
    function tutupLightbox() {
        if (lightbox) {
            lightbox.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Pasang event klik ke setiap item galeri
    if (galeriItems.length > 0) {
        galeriItems.forEach(function(item) {
            item.style.cursor = 'pointer';
            item.onclick = function(e) {
                // Cari gambar di dalam item ini
                const img = this.querySelector('img');
                if (img && img.src) {
                    e.stopPropagation();
                    bukaLightbox(img.src);
                }
                return false;
            };
        });
    }

    // Tutup lightbox kalau klik tombol close
    if (lightboxClose) {
        lightboxClose.onclick = function(e) {
            e.stopPropagation();
            tutupLightbox();
        };
    }

    // Tutup lightbox kalau klik di luar gambar (background)
    if (lightbox) {
        lightbox.onclick = function(e) {
            if (e.target === lightbox) {
                tutupLightbox();
            }
        };
    }

    // Tutup lightbox dengan tombol ESC
    document.onkeydown = function(e) {
        if (e.key === 'Escape' && lightbox && lightbox.style.display === 'flex') {
            tutupLightbox();
        }
    };

    // Kategori Slider
    const kategoriSlider = document.getElementById('kategoriSlider');
    const kategoriNextBottom = document.querySelector('.kategori-next-bottom');
    const kategoriPrevBottom = document.querySelector('.kategori-prev-bottom');

    if (kategoriSlider && kategoriNextBottom && kategoriPrevBottom) {
        kategoriNextBottom.onclick = function() {
            kategoriSlider.scrollBy({ left: 320, behavior: 'smooth' });
        };
        kategoriPrevBottom.onclick = function() {
            kategoriSlider.scrollBy({ left: -320, behavior: 'smooth' });
        };
    }

    // Scroll Progress Bar
    const scrollProgress = document.getElementById('scrollProgress');
    
    window.addEventListener('scroll', function() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.scrollY;
        const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;
        
        if (scrollProgress) {
            scrollProgress.style.width = scrollPercentage + '%';
        }
        
        const header = document.querySelector('.header');
        if (header) {
            if (scrollTop > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });
    
    // Intersection Observer untuk fade-in effects
    const fadeElements = document.querySelectorAll('.fade-up, .fade-left, .fade-right, .zoom-in');
    const cardElements = document.querySelectorAll('.category-card, .berita-card, .galeri-item');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    fadeElements.forEach(function(el) {
        observer.observe(el);
    });
    
    cardElements.forEach(function(el) {
        observer.observe(el);
    });
</script>
@endpush