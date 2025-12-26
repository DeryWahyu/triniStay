<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriniStay - Temukan Kos Impian Anda</title>
    <meta name="description"
        content="TriniStay - Platform pencarian kos terbaik untuk mahasiswa. Temukan hunian nyaman dengan fitur pencarian teman sekamar yang cocok.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#beranda" class="logo">
                <div class="logo-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span>TriniStay</span>
            </a>
            <ul class="nav-menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#kos">Kos</a></li>
                <li><a href="#tentang-kami">Tentang Kami</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    <a href="{{ match (Auth::user()->role) { 'superadmin' => route('superadmin.dashboard'), 'owner' => route('owner.dashboard'), 'renter' => route('renter.dashboard')} }}"
                        class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                @endauth
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav-menu">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#kos">Kos</a></li>
            <li><a href="#tentang-kami">Tentang</a></li>
            <li><a href="#ulasan">Ulasan</a></li>
        </ul>
        <div class="mobile-nav-actions">
            @auth
                <a href="{{ match (Auth::user()->role) { 'superadmin' => route('superadmin.dashboard'), 'owner' => route('owner.dashboard'), 'renter' => route('renter.dashboard')} }}"
                    class="btn-primary btn-block">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline btn-block">Masuk</a>
            @endauth
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">TriniStay</h1>
            <h2 class="hero-subtitle">Jelajahi Kos Kami</h2>
            <p class="hero-description">
                Temukan tempat tinggal di Trini yang bukan hanya sekadar kamar, tapi ruang nyaman untuk
                beristirahat setelah aktivitas kampus. Jelajahi kos bersih dan nyaman yang mendukung fokus
                belajar dan keseharianmu.
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Kenapa Memilih Kami?</span>
                <h2 class="section-title">Fitur Unggulan <span class="text-gradient">TriniStay</span></h2>
                <p class="section-subtitle">Kami menyediakan pengalaman mencari kos yang berbeda dan lebih personal</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Cari Teman Sekamar</h3>
                    <p class="feature-desc">Temukan roommate yang cocok berdasarkan kebiasaan dan kepribadian dengan
                        sistem matching AI kami</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="feature-title">Lokasi Strategis</h3>
                    <p class="feature-desc">Semua kos terverifikasi berada di lokasi strategis dekat kampus,
                        transportasi, dan fasilitas umum</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Terjamin & Aman</h3>
                    <p class="feature-desc">Setiap kos sudah terverifikasi keasliannya dengan foto aktual dan informasi
                        pemilik yang valid</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Pembayaran Mudah</h3>
                    <p class="feature-desc">Booking dan bayar kos dengan mudah melalui berbagai metode pembayaran yang
                        tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Exclusive Listings Section -->
    <section class="listings-section" id="kos">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Rekomendasi Terbaik</span>
                <h2 class="section-title">Pilihan Kos <span class="text-gradient">Eksklusif</span></h2>
                <p class="section-subtitle">Kos-kos pilihan dengan fasilitas terbaik dan ulasan positif dari penghuni
                </p>
            </div>

            @if($boardingHouses->count() > 0)
                <!-- Alpine.js Carousel Container -->
                <div x-data="{ activeSlide: 0, totalSlides: {{ $boardingHouses->chunk(3)->count() }} }"
                    class="carousel-container">
                    <!-- Slides -->
                    <div class="carousel-slides">
                        @foreach($boardingHouses->chunk(3) as $slideIndex => $group)
                            <div x-show="activeSlide === {{ $slideIndex }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform translate-x-8"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" class="carousel-slide">
                                <div class="listings-grid">
                                    @foreach($group as $kost)
                                        <div class="property-card" data-type="{{ $kost->type }}">
                                            <!-- Card Image -->
                                            <div class="property-image">
                                                <img src="{{ $kost->first_image }}" alt="{{ $kost->name }}" loading="lazy">

                                                <!-- Overlay with View Button -->
                                                <div class="property-overlay">
                                                    <a href="{{ route('kost.detail', $kost->slug) }}" class="btn-view">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                        Lihat Detail
                                                    </a>
                                                </div>

                                                <!-- Gender Type Badge -->
                                                <span
                                                    class="property-badge {{ $kost->type === 'putra' ? 'badge-putra' : ($kost->type === 'putri' ? 'badge-putri' : 'badge-campur') }}">
                                                    {{ $kost->type_label }}
                                                </span>

                                                <!-- Room Match (Berbagi Kamar) -->
                                                @if($kost->is_room_match_enabled)
                                                    <span class="room-match-badge available" title="Kos ini mendukung berbagi kamar">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2">
                                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="9" cy="7" r="4"></circle>
                                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Card Content -->
                                            <div class="property-content">
                                                <!-- Location -->
                                                <div class="property-location">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                        <circle cx="12" cy="10" r="3"></circle>
                                                    </svg>
                                                    <span>{{ Str::limit($kost->address, 30) }}</span>
                                                </div>

                                                <!-- Title -->
                                                <h3 class="property-name">{{ $kost->name }}</h3>

                                                <!-- Room Specifications (Real Data) -->
                                                <div class="property-specs">
                                                    @if($kost->room_size)
                                                        <span class="spec-item">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                            </svg>
                                                            {{ $kost->room_size }}
                                                        </span>
                                                    @endif
                                                    @if($kost->total_rooms)
                                                        <span class="spec-item">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                            </svg>
                                                            {{ $kost->total_rooms }} Kamar
                                                        </span>
                                                    @endif
                                                    @if($kost->available_rooms)
                                                        <span class="spec-item available">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                            </svg>
                                                            {{ $kost->available_rooms }} Tersedia
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Footer: Price & Booking -->
                                                <div class="property-footer">
                                                    <div class="property-price">
                                                        <span class="price-amount">{{ $kost->formatted_price_monthly }}</span>
                                                        <span class="price-period">/bulan</span>
                                                    </div>
                                                    <a href="{{ route('kost.detail', $kost->slug) }}" class="btn-book">Pesan Sekarang</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination Dots -->
                    <div class="carousel-dots">
                        @foreach($boardingHouses->chunk(3) as $slideIndex => $group)
                            <button @click="activeSlide = {{ $slideIndex }}"
                                :class="{ 'active': activeSlide === {{ $slideIndex }} }" class="carousel-dot"
                                aria-label="Slide {{ $slideIndex + 1 }}"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="no-listings">
                    <div class="no-listings-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <h3>Belum Ada Kos Tersedia</h3>
                    <p>Kos akan segera ditambahkan. Pantau terus halaman ini!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section" id="tentang-kami">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-image">
                    <div class="about-image-main">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80"
                            alt="Kos Modern">
                    </div>
                    <div class="about-image-float">
                        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&q=80"
                            alt="Kamar Kos Nyaman">
                    </div>
                    <div class="about-experience">
                        <span class="exp-number">5+</span>
                        <span class="exp-text">Tahun Pengalaman</span>
                    </div>
                </div>
                <div class="about-content">
                    <span class="section-badge">Tentang Kami</span>
                    <h2 class="about-title">Platform Pencarian Kos <span class="text-gradient">Terpercaya</span> untuk
                        Mahasiswa</h2>
                    <p class="about-text">
                        TriniStay adalah platform web inovatif yang membantu mahasiswa menemukan hunian ideal di sekitar
                        kampus. Kami memahami bahwa mencari kos bukan hanya tentang ketersediaan kamar, tetapi juga
                        tentang menemukan lingkungan yang nyaman.
                    </p>
                    <p class="about-text">
                        Dengan fitur <strong>Cari Teman Sekamar</strong>, kami mencocokkan calon penyewa berdasarkan
                        kebiasaan, preferensi, dan gaya hidup. Sistem kami memberikan rekomendasi teman sekamar yang
                        paling sesuai untuk pengalaman tinggal yang harmonis.
                    </p>
                    <div class="about-features">
                        <div class="about-feature">
                            <div class="about-feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span>Kos Terverifikasi</span>
                        </div>
                        <div class="about-feature">
                            <div class="about-feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span>Proses Booking Cepat</span>
                        </div>
                        <div class="about-feature">
                            <div class="about-feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span>Support 24/7</span>
                        </div>
                        <div class="about-feature">
                            <div class="about-feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <span>Matching Roommate</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="ulasan">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Testimoni</span>
                <h2 class="section-title">Apa Kata <span class="text-gradient">Mereka?</span></h2>
                <p class="section-subtitle">Dengarkan pengalaman nyata dari para penghuni yang telah menemukan
                    kenyamanan di TriniStay</p>
            </div>

            <div class="testimonials-grid">
                @forelse($reviews as $review)
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div class="testimonial-info">
                                <h4 class="testimonial-name">{{ $review->user->name }}</h4>
                                <p class="testimonial-kost">{{ $review->boardingHouse->name }}</p>
                            </div>
                            <div class="testimonial-quote">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                            </div>
                        </div>
                        <p class="testimonial-text">"{{ Str::limit($review->comment, 180) }}"</p>
                        <div class="testimonial-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                            @endfor
                        </div>
                    </div>
                @empty
                    <!-- Default testimonials -->
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">A</div>
                            <div class="testimonial-info">
                                <h4 class="testimonial-name">Andi Pratama</h4>
                                <p class="testimonial-kost">Kos Griya Mahasiswa</p>
                            </div>
                            <div class="testimonial-quote">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                            </div>
                        </div>
                        <p class="testimonial-text">"Sistem pencarian teman sekamar sangat membantu! Saya menemukan roommate
                            yang cocok dan kami jadi teman baik. TriniStay tidak hanya tempat tinggal, tapi juga tempat
                            membangun persahabatan baru."</p>
                        <div class="testimonial-rating">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">S</div>
                            <div class="testimonial-info">
                                <h4 class="testimonial-name">Sarah Wijaya</h4>
                                <p class="testimonial-kost">Kos Putri Harmoni</p>
                            </div>
                            <div class="testimonial-quote">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                            </div>
                        </div>
                        <p class="testimonial-text">"Platform yang user-friendly dan proses booking sangat cepat. Dalam
                            hitungan hari saya sudah bisa pindah ke kos baru. Recommended banget untuk mahasiswa!"</p>
                        <div class="testimonial-rating">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">R</div>
                            <div class="testimonial-info">
                                <h4 class="testimonial-name">Rizki Ramadhan</h4>
                                <p class="testimonial-kost">Kos Putra Sejahtera</p>
                            </div>
                            <div class="testimonial-quote">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.1">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                            </div>
                        </div>
                        <p class="testimonial-text">"Tinggal di kos TriniStay sangat nyaman. Kamar bersih, fasilitas
                            lengkap, dan harga terjangkau. Sangat recommended untuk mahasiswa yang cari kos berkualitas!"
                        </p>
                        <div class="testimonial-rating">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Siap Menemukan Kos Impianmu?</h2>
                <p class="cta-text">Bergabung dengan ribuan mahasiswa yang sudah menemukan hunian nyaman melalui
                    TriniStay</p>
                <div class="cta-buttons">
                    <a href="#kos" class="btn-cta-primary">
                        Cari Kos Sekarang
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#tentang-kami" class="btn-cta-secondary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#beranda" class="footer-logo">
                        <div class="logo-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span>TriniStay</span>
                    </a>
                    <p class="footer-desc">
                        Temukan hunian nyaman yang mendukung fokus belajar dan istirahat berkualitas. Platform pencarian
                        kos terpercaya untuk mahasiswa Indonesia.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4 class="footer-title">Menu</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#kos">Cari Kos</a></li>
                        <li><a href="#tentang-kami">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4 class="footer-title">Layanan</h4>
                    <ul>
                        <li><a href="#">Cari Teman Sekamar</a></li>
                        <li><a href="#">Daftar Kos</a></li>
                        <li><a href="#">Verifikasi Kos</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4 class="footer-title">Hubungi Kami</h4>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Jl. Babarsari 2, Jarno 04, 55281 Sleman, DIY</span>
                    </div>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                        <span>+62 812 3456 7890</span>
                    </div>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>hello@trinistay.com</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} TriniStay. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/landing.js') }}"></script>
</body>

</html>
