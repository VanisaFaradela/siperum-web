<?php
use Illuminate\Support\Facades\DB;

$kontak = DB::table('kontak')->first();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Homepage - ' . ($cluster->nama_cluster ?? 'Cluster'))</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    @stack('styles')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ========== HEADER / NAVBAR ========== */
        .header {
            background: white;
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .nav-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
        }

        .logo-link:hover {
            color: #333;
            text-decoration: none;
        }

        .logo-icon {
            color: #2e7d32;
            font-size: 24px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }

        .nav-menu {
            display: flex;
            gap: 40px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu li a {
            text-decoration: none;
            color: #181E4B;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-menu li a:hover {
            color: #A7E27B;
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #A7E27B;
            transition: width 0.3s;
        }

        .nav-menu li a:hover::after {
            width: 100%;
        }

        .nav-menu li a.active {
            color: #A7E27B;
        }

        .nav-menu li a.active::after {
            width: 100%;
        }

        /* ========== DROPDOWN MENU ========== */
        .nav-menu li.dropdown {
            position: relative;
        }

        .nav-menu li.dropdown > a {
            display: inline-flex !important;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            line-height: 1;
        }

        .nav-menu li.dropdown > a::after {
            content: '\f0d7'; 
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            display: inline-block;
            margin-left: 6px;
            position: relative;
            top: -5px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            list-style: none;
            padding: 10px 0;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            min-width: 220px;
            z-index: 1000;
            border: 1px solid #f0f0f0;
        }

        .nav-menu li.dropdown:hover .dropdown-menu {
            display: block;
            animation: dropdownSlide 0.3s ease-out;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-menu li {
            margin: 0;
        }

        .dropdown-menu li a {
            display: block;
            padding: 11px 18px;
            color: #181E4B;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .dropdown-menu li:first-child a {
            border-radius: 12px 12px 0 0;
        }

        .dropdown-menu li:last-child a {
            border-radius: 0 0 12px 12px;
        }

        .dropdown-menu li a:hover {
            background: #A7E27B;
            color: #181E4B;
            padding-left: 22px;
        }

        .dropdown-menu li a::after {
            display: none !important;
        }

        /* ========== TOMBOL CONTACT US ========== */
        .contact-us-btn {
            position: absolute;
            right: 0;
            display: inline-block;
            padding: 8px 22px;
            background: #A7E27B;
            color: #181E4B;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .contact-us-btn:hover {
            background: #181E4B;
            color: #A7E27B;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .contact-us-btn {
                position: static;
                margin-left: auto;
                margin-right: 15px;
                padding: 6px 16px;
                font-size: 12px;
            }
        }

        /* ========== HAMBURGER MENU ========== */
        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            padding: 10px;
            z-index: 1001;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background: #181E4B;
            margin: 5px 0;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background: white;
            z-index: 1000;
            transition: right 0.3s ease;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            padding: 70px 20px 20px !important;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .mobile-menu ul li {
            margin-bottom: 20px;
        }

        .mobile-menu ul li a {
            text-decoration: none;
            color: #181E4B;
            font-weight: 500;
            font-size: 18px;
            display: block;
            padding: 10px 0;
            transition: all 0.3s;
        }

        .mobile-menu ul li a:hover {
            color: #A7E27B;
            padding-left: 10px;
        }

        .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 35px;
            height: 35px;
            background: #A7E27B;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 1002;
        }

        .close-menu:hover {
            background: #181E4B;
            transform: rotate(90deg);
        }

        .close-menu:hover i {
            color: #A7E27B;
        }

        .close-menu i {
            font-size: 18px;
            color: #181E4B;
            transition: all 0.3s;
        }

        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        .menu-overlay.active {
            display: block;
        }

        /* ========== FOOTER ========== */
        .footer {
            background: #A7E27B;
            color: #181E4B;
            padding: 50px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            margin-bottom: 20px;
            font-size: 18px;
            color: #181E4B;
            font-weight: 700;
        }

        .footer-section p, .footer-section a {
            color: #1a1a2e;
            text-decoration: none;
            line-height: 1.8;
            font-weight: 500;
        }

        .footer-section a:hover {
            color: #0d0d1a;
            text-decoration: underline;
        }

        .footer-section i {
            margin-right: 10px;
            color: #181E4B;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background-color: rgba(24, 30, 75, 0.1);
            text-align: center;
            line-height: 45px;
            font-size: 20px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 2px solid #181E4B;
            z-index: 1;
            transition: 0.5s;
        }

        .social-links a i {
            position: relative;
            color: #181E4B;
            transition: 0.5s;
            z-index: 3;
        }

        .social-links a:hover i {
            color: #A7E27B;
            transform: rotateY(360deg);
        }

        .social-links a::before {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: #181E4B;
            transition: 0.5s;
            z-index: 2;
        }

        .social-links a:hover::before {
            top: 0;
        }

        .social-links a:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(24, 30, 75, 0.3);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(24, 30, 75, 0.2);
            color: #1a1a2e;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #181E4B;
            color: #A7E27B;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .nav-container {
                justify-content: space-between !important;
            }
            
            .logo {
                position: relative !important;
                left: auto !important;
                margin-bottom: 0 !important;
            }
            
            .nav-menu {
                display: none !important;
            }
            
            .hamburger {
                display: block !important;
            }
        }

        @media (min-width: 769px) {
            .hamburger, .mobile-menu, .menu-overlay {
                display: none !important;
            }
        }

        /* ========== SCROLL EFFECTS ========== */
        html {
            scroll-behavior: smooth;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

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

        .header.scrolled {
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }
    </style>
    
    @stack('styles-extra')
</head>
<body>
   <!-- Scroll Progress Bar -->
    <div class="scroll-progress" id="scrollProgress"></div>
    
    <!-- HEADER / NAVBAR -->
    <header class="header">
        <div class="container">
            <div class="nav-container">
                <div class="logo">
                    <a href="{{ route('home') }}" class="logo-link">
                        <div class="logo-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="logo-text">
                            SIPERUM
                        </div>
                    </a>
                </div>
                <ul class="nav-menu">
                    <li><a href="{{ route('home') }}" class="@if(Route::currentRouteName() == 'home') active @endif">Home</a></li>
                    <li><a href="{{ route('tentang') }}" class="@if(Route::currentRouteName() == 'tentang') active @endif">Tentang Kami</a></li>
                    <li class="dropdown">
                        <a href="{{ route('cluster.index') }}#kategori">Cluster</a>
                        <ul class="dropdown-menu">
                            @forelse($clusters as $clusterItem)
                                <li>
                                    <a href="{{ route('cluster.index', $clusterItem->id_cluster) }}">
                                        {{ $clusterItem->nama_cluster }}
                                    </a>
                                </li>
                            @empty
                                <li><a href="{{ route('cluster.index') }}">Belum ada cluster</a></li>
                            @endforelse
                        </ul>
                    </li>
                    <li><a href="{{ route('berita.index') }}" class="@if(Route::currentRouteName() == 'berita.index') active @endif">Berita</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="@if(Route::currentRouteName() == 'galeri.index') active @endif">Galeri</a></li>
                </ul>

                 <!-- TOMBOL CONTACT US (DI SEBELAH KANAN) -->
                <a href="#footer" class="contact-us-btn">Contact Us</a>

                <button class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="close-menu" id="closeMenuBtn">
            <i class="fas fa-times"></i>
        </div>
        <ul>
            <li><a href="{{ route('home') }}" class="mobile-link">Home</a></li>
            <li><a href="{{ route('tentang') }}" class="mobile-link">Tentang Kami</a></li>
            <li class="dropdown">
                <a href="{{ route('cluster.index') }}#kategori">Cluster</a>
                <ul class="dropdown-menu">
                    @forelse($clusters as $clusterItem)
                        <li>
                            <a href="{{ route('cluster.index', $clusterItem->id_cluster) }}">
                                {{ $clusterItem->nama_cluster }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('cluster.index') }}">Belum ada cluster</a></li>
                    @endforelse
                </ul>
                </li>
            <li><a href="{{ route('berita.index') }}" class="mobile-link">Berita</a></li>
            <li><a href="{{ route('galeri.index') }}" class="mobile-link">Galeri</a></li>
        </ul>
    </div>

    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer" id="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>{{ $cluster->nama_cluster ?? 'Cluster' }}</h4>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $kontak->perusahaan ?? 'Perusahaan' }}</p>
                    <p><i class="fas fa-phone"></i> {{ $kontak->telepon ?? '-' }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $kontak->email ?? '-' }}</p>
                </div>
                <div class="footer-section">
                    <h4>Follow Kami</h4>
                    <div class="social-links">
                        <a href="{{ $kontak->facebook ?? '#' }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $kontak->instagram ?? '#' }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $kontak->twitter ?? '#' }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $kontak->youtube ?? '#' }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="{{ $kontak->linkedin ?? '#' }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="{{ $kontak->tiktok ?? '#' }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Kirim Pesan</h4>
                    @if(session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('message.submit') }}" method="POST">
                        @csrf
                        <input type="text" name="nama" placeholder="Nama" style="width:100%; padding:10px; margin-bottom:10px; border-radius:50px; border:none;">
                        <input type="email" name="email" placeholder="Email" style="width:100%; padding:10px; margin-bottom:10px; border-radius:50px; border:none;">
                        <input type="text" name="telepon" placeholder="Telepon" style="width:100%; padding:10px; margin-bottom:10px; border-radius:50px; border:none;">
                        <textarea name="pesan" placeholder="Pesan" rows="2" style="width:100%; padding:10px; margin-bottom:10px; border-radius:10px; border:none;"></textarea>
                        <button type="submit" style="background:#181E4B; color:#A7E27B; padding:10px 25px; border:none; border-radius:50px; cursor:pointer; font-weight:600;">Kirim</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SIPERUM. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Hamburger Menu
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOverlay = document.getElementById('menuOverlay');
        const mobileLinks = document.querySelectorAll('.mobile-link');
        const closeMenuBtn = document.getElementById('closeMenuBtn');

        function toggleMenu() {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        }

        function closeMenu() {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (hamburger) hamburger.addEventListener('click', toggleMenu);
        if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);
        if (closeMenuBtn) closeMenuBtn.addEventListener('click', closeMenu);
        mobileLinks.forEach(link => link.addEventListener('click', closeMenu));

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mobileMenu && mobileMenu.classList.contains('active')) closeMenu();
        });

        // Scroll Progress Bar
       const progressBar = document.getElementById('scrollProgress');
        
        window.addEventListener('scroll', () => {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.scrollY;
            const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;
            if (progressBar) progressBar.style.width = scrollPercentage + '%';
            
            const header = document.querySelector('.header');
            if (header) {
                if (scrollTop > 50) header.classList.add('scrolled');
                else header.classList.remove('scrolled');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>