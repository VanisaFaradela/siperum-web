@extends('layouts.app')

@section('title', 'Galeri - ' . ($cluster->nama_cluster ?? 'Cluster'))

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

    .galeri-page-section {
        padding: 60px 0;
    }

    /* Filter Tabs */
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
        font-family: 'Poppins', sans-serif;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #A7E27B;
        color: #181E4B;
    }

    /* Galeri Grid */
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    .galeri-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        aspect-ratio: 1 / 1;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .galeri-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px rgba(0,0,0,0.2);
    }

    .galeri-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s;
    }

    .galeri-item:hover img {
        transform: scale(1.05);
    }

    .galeri-overlay {
        position: absolute;
        bottom: -100%;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(24,30,75,0.9), transparent);
        color: white;
        transition: bottom 0.3s;
    }

    .galeri-item:hover .galeri-overlay {
        bottom: 0;
    }

    .galeri-overlay h4 {
        font-size: 16px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .galeri-overlay p {
        font-size: 12px;
        opacity: 0.8;
    }

    .galeri-overlay i {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 20px;
        color: white;
        background: rgba(0,0,0,0.5);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back {
        display: inline-block;
        padding: 10px 25px;
        background: transparent;
        border: 2px solid #A7E27B;
        color: #181E4B;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #A7E27B;
        transform: translateY(-2px);
    }

    /* Lightbox Modal */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        cursor: pointer;
        align-items: center;
        justify-content: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 85%;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }

    .lightbox-caption {
        position: absolute;
        bottom: 30px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-size: 16px;
        background: rgba(0,0,0,0.6);
        padding: 10px 20px;
        width: fit-content;
        margin: 0 auto;
        border-radius: 50px;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 45px;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10000;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
    }

    .lightbox-close:hover {
        color: #A7E27B;
        transform: rotate(90deg);
        background: rgba(0,0,0,0.8);
    }

    .lightbox-prev,
    .lightbox-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 40px;
        cursor: pointer;
        transition: all 0.3s;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
    }

    .lightbox-prev {
        left: 30px;
    }

    .lightbox-next {
        right: 30px;
    }

    .lightbox-prev:hover,
    .lightbox-next:hover {
        color: #A7E27B;
        background: rgba(0,0,0,0.8);
    }

    .no-galeri {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
        color: #999;
    }

    /* Pagination */
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

    @media (max-width: 992px) {
        .galeri-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section h1 { font-size: 32px; }
        .galeri-grid { grid-template-columns: 1fr; padding: 0 20px; }
        .galeri-item { aspect-ratio: 4 / 3; }
        .lightbox-prev, .lightbox-next { width: 35px; height: 35px; font-size: 25px; }
        .lightbox-prev { left: 10px; }
        .lightbox-next { right: 10px; }
        .lightbox-close { top: 15px; right: 15px; width: 40px; height: 40px; font-size: 30px; }
        .lightbox-caption { font-size: 12px; bottom: 15px; }
    }
</style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container">
            <h1>Galeri</h1>
            <p>Galeri foto properti dan perumahan</p>
        </div>
    </section>

    <section class="galeri-page-section">
        <div class="container">
            <div class="galeri-filter">
                <button class="filter-btn active" data-filter="all">Semua</button>
                @foreach($kategoriGaleri as $kategori)
                <button class="filter-btn" data-filter="{{ strtolower($kategori) }}">{{ ucfirst($kategori) }}</button>
                @endforeach
            </div>

            <div class="galeri-grid" id="galeriGrid">
                @forelse($galeri as $item)
                <div class="galeri-item" data-category="{{ $item->kategori_foto ?? 'umum' }}" data-id="{{ $item->id_galeri }}">
                    <img src="{{ $item->gambar ? route('media.galeri', $item->gambar) : 'https://via.placeholder.com/400x400?text=Gambar+Tidak+Tersedia' }}" alt="{{ $item->judul_galeri }}">
                    <div class="galeri-overlay">
                        <i class="fas fa-search-plus"></i>
                        <h4>{{ $item->judul_galeri }}</h4>
                        <p>{{ $item->kategori_foto ?? 'Foto' }}</p>
                    </div>
                </div>
                @empty
                <p style="text-align: center; grid-column: 1/-1; padding: 50px;">Belum ada data galeri.</p>
                @endforelse
            </div>

            @if(isset($galeri) && method_exists($galeri, 'links'))
            <div class="pagination">
                {{ $galeri->links() }}
            </div>
            @endif
        </div>
        <!-- Tombol Kembali ke Beranda -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('home') }}#galeri" class="btn-back"> Kembali ke Beranda</a>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-close">&times;</div>
        <div class="lightbox-prev"><i class="fas fa-chevron-left"></i></div>
        <div class="lightbox-next"><i class="fas fa-chevron-right"></i></div>
        <img id="lightboxImg" src="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
@endsection

@push('scripts')
<script>
    // Filter Galeri
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galeriItems = document.querySelectorAll('.galeri-item');
    let currentIndex = 0;
    let currentItems = [];

    function updateCurrentItems() {
        currentItems = [];
        galeriItems.forEach(item => {
            if (item.style.display !== 'none') {
                currentItems.push(item);
            }
        });
    }

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
                
                updateCurrentItems();
            });
        });
    }

    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');

    function openLightbox(index) {
        if (currentItems.length === 0) updateCurrentItems();
        
        if (index >= 0 && index < currentItems.length) {
            currentIndex = index;
            const item = currentItems[currentIndex];
            const img = item.querySelector('img');
            const title = item.querySelector('.galeri-overlay h4')?.innerText || 'Galeri';
            const category = item.getAttribute('data-category');
            
            lightboxImg.src = img.src;
            lightboxCaption.innerHTML = `<i class="fas fa-image"></i> ${title} - ${category}`;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function prevImage() {
        if (currentIndex > 0) openLightbox(currentIndex - 1);
        else openLightbox(currentItems.length - 1);
    }

    function nextImage() {
        if (currentIndex < currentItems.length - 1) openLightbox(currentIndex + 1);
        else openLightbox(0);
    }

    updateCurrentItems();
    
    galeriItems.forEach((item, idx) => {
        item.addEventListener('click', function(e) {
            if (e.target.classList.contains('galeri-overlay') || 
                e.target.tagName === 'H4' || 
                e.target.tagName === 'P' || 
                e.target.tagName === 'I') {
                return;
            }
            const index = currentItems.indexOf(this);
            openLightbox(index >= 0 ? index : idx);
        });
    });

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightbox) lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
    });
    if (lightboxPrev) lightboxPrev.addEventListener('click', prevImage);
    if (lightboxNext) lightboxNext.addEventListener('click', nextImage);
    
    document.addEventListener('keydown', function(e) {
        if (lightbox && lightbox.classList.contains('active')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        }
    });
</script>
@endpush