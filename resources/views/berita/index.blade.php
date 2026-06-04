@extends('layouts.app')

@section('title', 'Berita - ' . ($cluster->nama_cluster ?? 'Cluster'))

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

    .berita-page-section {
        padding: 60px 0;
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
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .berita-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 45px rgba(0,0,0,0.15);
    }

    .berita-image {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .berita-date {
        padding: 12px 20px 0;
        color: #A7E27B;
        font-size: 12px;
        font-weight: 600;
    }

    .berita-date i {
        margin-right: 5px;
    }

    .berita-content {
        padding: 0 20px 20px;
    }

    .berita-content h3 {
        font-size: 18px;
        color: #181E4B;
        margin-bottom: 10px;
        line-height: 1.4;
        font-weight: 700;
    }

    .berita-content p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .berita-link {
        color: #A7E27B;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
    }

    .berita-link:hover {
        gap: 10px;
        color: #181E4B;
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
        transition: all 0.3s;
    }

    .pagination a:hover {
        background: #A7E27B;
        border-color: #A7E27B;
        color: #181E4B;
    }

    .pagination .active span {
        background: #A7E27B;
        border-color: #A7E27B;
        color: #181E4B;
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

    @media (max-width: 992px) {
        .berita-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section h1 { font-size: 32px; }
        .berita-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container">
            <h1>Berita</h1>
            <p>Informasi terbaru seputar properti dan perumahan</p>
        </div>
    </section>

    <section class="berita-page-section">
        <div class="container">
            <div class="berita-grid">
                @forelse($berita as $item)
                <a href="{{ route('berita.show', $item->slug) }}" class="berita-card">
                    <div class="berita-image" style="background-image:url('{{ route('media.berita', $item->gambar) }}')"></div>
                    <div class="berita-date">
                        <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                    </div>
                    <div class="berita-content">
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->isi_berita, 120) }}</p>
                        <span class="berita-link">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: 20px; color: #666;">
                    <h3>Tidak ada berita tersedia</h3>
                    <p>Belum ada berita yang dipublikasikan saat ini.</p>
                </div>
                @endforelse
            </div>

            <!-- Tombol Kembali ke Beranda -->
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('home') }}#berita" class="btn-back"> Kembali ke Beranda</a>
            </div>

            @if(method_exists($berita, 'links'))
            <div class="pagination">
                {{ $berita->links() }}
            </div>
            @endif
        </div>
    </section>
@endsection