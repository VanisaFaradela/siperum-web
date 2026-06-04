@extends('layouts.app')

@section('title', $berita->judul . ' - ' . ($cluster->nama_cluster ?? 'Cluster'))

@push('styles')
<style>
    .berita-detail-hero {
        background: linear-gradient(135deg, #A7E27B 0%, #8fc86a 100%);
        padding: 60px 0;
        text-align: center;
        color: #181E4B;
    }

    .berita-detail-hero h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .berita-meta {
        display: flex;
        justify-content: center;
        gap: 30px;
        font-size: 16px;
        color: #181E4B;
        opacity: 0.8;
    }

    .berita-detail-section {
        padding: 60px 0;
    }

    .berita-detail-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .berita-detail-image {
        width: 100%;
        height: 450px;
        background-size: cover;
        background-position: center;
    }

    .berita-detail-content {
        padding: 40px;
    }

    .berita-detail-date {
        color: #A7E27B;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .berita-detail-content h1 {
        font-size: 32px;
        color: #181E4B;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .berita-detail-text {
        color: #444;
        font-size: 16px;
        line-height: 1.8;
        margin-top: 20px;
    }

    .berita-detail-text p {
        margin-bottom: 20px;
    }

    .berita-source {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        font-size: 12px;
        color: #999;
        font-style: italic;
    }

    .berita-source a {
        color: #A7E27B;
        text-decoration: none;
    }

    .btn-back {
        display: inline-block;
        margin-top: 30px;
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
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .berita-detail-hero h1 { font-size: 32px; }
        .berita-detail-image { height: 250px; }
        .berita-detail-content { padding: 25px; }
        .berita-detail-content h1 { font-size: 24px; }
    }
</style>
@endpush

@section('content')
    <section class="berita-detail-hero">
        <div class="container">
            <h1>{{ $berita->judul }}</h1>
            <div class="berita-meta">
                <span><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
            </div>
        </div>
    </section>

    <section class="berita-detail-section">
        <div class="container">
            <div class="berita-detail-container">
                <div class="berita-detail-image" style="background-image: url('{{ $berita->gambar ? route('media.berita', $berita->gambar) : 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&w=800&h=400&fit=crop' }}');"></div>
                <div class="berita-detail-content">
                    <div class="berita-detail-date">
                        <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}
                    </div>
                    <h1>{{ $berita->judul }}</h1>
                    <div class="berita-detail-text">
                        {!! nl2br(e($berita->konten ?? $berita->isi_berita)) !!}
                    </div>
                    
                    @if($berita->sumber ?? false)
                    <div class="berita-source">
                        <i class="fas fa-link"></i> Sumber: <a href="{{ $berita->sumber }}" target="_blank">{{ $berita->sumber }}</a>
                    </div>
                    @endif

                    <div style="text-align: center;">
                        <a href="{{ route('berita.index') }}" class="btn-back"> Kembali ke Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection