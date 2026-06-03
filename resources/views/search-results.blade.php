@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $search . ' - ' . ($cluster->nama_cluster ?? 'Cluster'))

@push('styles')
<style>
    .search-hero {
        background: linear-gradient(135deg, #A7E27B 0%, #8fc86a 100%);
        padding: 60px 0;
        text-align: center;
        color: #181E4B;
    }

    .search-hero h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    /* Grid for results */
    .results-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(240px, 1fr));
        gap: 28px;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .result-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,0.08);
        transition: all 0.35s ease;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .result-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 45px rgba(0,0,0,0.14);
    }

    .result-card .card-header {
        background: #A7E27B;
        padding: 18px;
        text-align: center;
        border-bottom: none;
    }

    .result-card .card-header h3 {
        color: #181E4B;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .result-card .card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .result-card .card-body .spec i {
        color: #A7E27B;
        margin-right: 5px;
        width: 20px;
    }

    .result-card .card-body .price {
        font-size: 18px;
        font-weight: 700;
        color: #A7E27B;
        margin: 15px 0;
    }

    .result-card .card-body .date {
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
    }

    .search-section-title {
        display: inline-block;
        font-size: 26px;
        font-weight: 700;
        color: #181E4B;
        margin-bottom: 24px;
        position: relative;
        padding-bottom: 10px;
    }

    .search-section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 4px;
        background: #A7E27B;
        border-radius: 999px;
    }

    .result-link {
        display: inline-block;
        padding: 10px 22px;
        background: #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 999px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s;
        margin-top: auto;
    }

    .result-link:hover {
        background: #181E4B;
        color: #A7E27B;
        transform: translateY(-2px);
    }

    .no-results {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
    }

    .no-results i {
        font-size: 60px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .no-results h3 {
        font-size: 24px;
        color: #181E4B;
        margin-bottom: 10px;
    }

    .no-results p {
        color: #666;
    }

    .btn-back {
        display: inline-block;
        margin-top: 30px;
        padding: 10px 25px;
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

    @media (max-width: 1200px) {
        .results-grid {
            grid-template-columns: repeat(3, minmax(220px, 1fr));
        }
    }

    @media (max-width: 992px) {
        .results-grid {
            grid-template-columns: repeat(2, minmax(220px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .search-hero h1 {
            font-size: 32px;
        }

        .results-grid {
            grid-template-columns: 1fr;
        }

        .search-section-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<section class="search-hero">
    <div class="container">
        <h1>Hasil Pencarian</h1>
        <p>
            Menampilkan hasil untuk keyword:
            <strong>"{{ $search }}"</strong>
        </p>
    </div>
</section>

<section class="search-results-section">
    <div class="container">

        @if($tipeRumah->count() > 0 || $berita->count() > 0)

            <!-- HASIL TIPE RUMAH -->
            @if(isset($clusters) && $clusters->count() > 0)
            <br></br>
            <h2 class="search-section-title"> Cluster</h2>

            <div class="results-grid">
                @foreach($clusters as $c)
                <div class="result-card">

                    <div class="card-header">
                        <h3>{{ $c->nama_cluster }}</h3>
                    </div>

                    <div class="card-body">

                        <p>{{ \Illuminate\Support\Str::limit($c->deskripsi_cluster ?? '-', 120) }}</p>

                        <a href="{{ route('cluster.show', $c->cluster_id) }}" class="result-link">
                            Lihat Detail
                            <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @if($tipeRumah->count() > 0)
            <h2 class="search-section-title"> Tipe Rumah</h2>

            <div class="results-grid">
                @foreach($tipeRumah as $tipe)
                <div class="result-card">

                    <div class="card-header">
                        <h3>{{ $tipe->nama_tipe }}</h3>
                    </div>

                    <div class="card-body">

                        <div class="spec">
                            <i class="fas fa-map-marker-alt"></i>
                            Cluster:
                            {{ $tipe->cluster->nama_cluster ?? '-' }}
                        </div>

                        <div class="spec">
                            <i class="fas fa-vector-square"></i>
                            Luas Tanah:
                            {{ number_format($tipe->luas_tanah ?? 0) }} m²
                        </div>

                        <div class="spec">
                            <i class="fas fa-building"></i>
                            Luas Bangunan:
                            {{ number_format($tipe->luas_bangunan ?? 0) }} m²
                        </div>

                        <div class="spec">
                            <i class="fas fa-bed"></i>
                            Kamar Tidur:
                            {{ $tipe->kamar_tidur ?? 0 }}
                        </div>

                        <div class="spec">
                            <i class="fas fa-bath"></i>
                            Kamar Mandi:
                            {{ $tipe->kamar_mandi ?? 0 }}
                        </div>

                        <div class="spec">
                            <i class="fas fa-car"></i>
                            Carport:
                            {{ $tipe->carport ?? 0 }}
                        </div>

                        <div class="spec">
                            <i class="fas fa-home"></i>
                            Status:
                            {{ ucfirst($tipe->status ?? 'tersedia') }}
                        </div>

                        <div class="price">
                            Rp {{ number_format($tipe->harga ?? 0, 0, ',', '.') }}
                        </div>

                        <a href="{{ route('tipe-detail', $tipe->id_tipe) }}" class="result-link">
                            Lihat Detail
                            <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>
                </div>
                @endforeach
            </div>
            @endif


            <!-- HASIL BERITA -->
            @if($berita->count() > 0)

            <h2 class="search-section-title"> Berita</h2>

            <div class="results-grid">

                @foreach($berita as $item)

                <div class="result-card">

                    <div class="card-header">
                        <h3>{{ Str::limit($item->judul, 40) }}</h3>
                    </div>

                    <div class="card-body">

                        <div class="date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                        </div>

                        <p>
                            {{ Str::limit(strip_tags($item->konten ?? $item->isi_berita ?? 'Tidak ada deskripsi'), 100) }}
                        </p>

                        <a href="{{ route('berita.show', $item->slug ?? $item->id_berita) }}" class="result-link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>

                </div>

                @endforeach

            </div>

            @endif

        @else

            <div class="no-results">

                <i class="fas fa-search"></i>

                <h3>Tidak ditemukan hasil</h3>

                <p>
                    Maaf, tidak ada data yang cocok dengan kata kunci
                    "<strong>{{ $search }}</strong>".
                </p>

                <p>
                    Coba gunakan kata kunci lain seperti:
                    Tipe 36, Tipe 45, Cluster, atau berita.
                </p>

                <a href="{{ route('home') }}" class="btn-back"> Kembali ke Beranda</a>
            </div>

        @endif

        <!-- TOMBOL KEMBALI -->
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('home') }}" class="btn-back"> Kembali ke Beranda</a>
        </div>
        <br></br>

    </div>
</section>
@endsection