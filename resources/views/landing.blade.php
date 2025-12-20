<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriniStay - Jelajahi Kos Kami</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="hero-overlay"></div>

        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>TriniStay</span>
                </div>
                <ul class="nav-menu">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#kos">Kos</a></li>
                    <li><a href="#tentang-kami">Tentang Kami</a></li>
                </ul>
                @auth
                    <div class="nav-auth">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <a href="{{ match(Auth::user()->role) { 'superadmin' => route('dashboard.admin'), 'owner' => route('owner.dashboard'), 'renter' => route('renter.dashboard') } }}" class="btn-masuk">Dashboard</a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                @endauth
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="hero-content">
            <h1 class="hero-title">TriniStay</h1>
            <h2 class="hero-subtitle">Jelajahi Kos Kami</h2>
            <p class="hero-description">
                Temukan tempat tinggal terbaik yang sesuai dengan gaya hidup Anda. Ratusan kos berkualitas dengan fasilitas lengkap, harga terjangkau, dan lokasi strategis yang memudahkan akses kuliah dan bekerja dalam kenyamanan.
            </p>
        </div>
    </section>

    <!-- Exclusive Listings Section -->
    <section class="listings-section" id="kos">
        <div class="container">
            <h2 class="section-title">Pilihan Kos Eksklusif</h2>

            <div class="carousel-wrapper">
                <div class="carousel-container">
                    @forelse($boardingHouses as $kost)
                    <div class="property-card">
                        <div class="property-image">
                            @if($kost->images && count($kost->images) > 0)
                                <img src="{{ asset('storage/' . $kost->images[0]) }}" alt="{{ $kost->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80" alt="{{ $kost->name }}">
                            @endif
                            <span class="property-type-badge {{ $kost->type === 'putra' ? 'badge-putra' : ($kost->type === 'putri' ? 'badge-putri' : 'badge-campur') }}">
                                {{ $kost->type_label }}
                            </span>
                        </div>
                        <div class="property-info">
                            <h3 class="property-name">{{ $kost->name }}</h3>
                            <p class="property-location">{{ Str::limit($kost->address, 40) }}</p>
                            <div class="property-footer">
                                <p class="property-price">{{ $kost->formatted_price_monthly }}<span class="price-period">/bulan</span></p>
                                <a href="{{ route('kost.detail', $kost->slug) }}" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-kost-message">
                        <p>Belum ada kos yang tersedia saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if($boardingHouses->count() > 3)
            <div class="carousel-pagination">
                @for($i = 0; $i < ceil($boardingHouses->count() / 3); $i++)
                <span class="dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></span>
                @endfor
            </div>
            @endif
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section" id="tentang-kami">
        <div class="container">
            <h2 class="section-title">Tentang Kami</h2>
            <div class="about-content">
                <p class="about-text">
                    Sistem Reservasi Kos Trini adalah platform web yang membantu mahasiswa menemukan hunian sementara di daerah sekitar kampus oleh teman sekelas yang hendak menawarkan kos kepada orang lain. Kami memahami bahwa mencari kos bukan hanya soal ketersediaan kamar, tetapi juga kenyamanan dalam berbagi ruang dengan orang lain. Melalui fitur Cari Teman, kami mencocokkan calon penyewa berdasarkan kuisioner mengenai kebiasaan, preferensi, dan pola hidup. Sistem kami memberikan rekomendasi teman sekamar yang paling sesuai, sehingga mahasiswa dapat tinggal dengan lebih nyaman dan minim konflik. Dengan layanan pencarian kos yang lengkap dan fitur kecocokan teman sekamar, Kos Trini menjadi solusi praktis bagi mahasiswa yang ingin menemukan tempat tinggal ideal di lokasi dekat kampus. Kami hadir untuk membuat proses mencari kos lebih mudah, cepat, dan tepat.
                </p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title">Ulasan Kami</h2>
            <p class="section-subtitle">Dengarkan pengalaman nyata dari para penghuni yang telah menemukan kenyamanan mereka di TriniStay</p>

            <div class="testimonials-carousel-wrapper">
                <div class="testimonials-container">
                    @forelse($reviews as $review)
                    <div class="testimonial-card">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">
                            "{{ Str::limit($review->comment, 200) }}"
                        </p>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <p class="reviewer-name">{{ $review->user->name }}</p>
                        <p class="reviewer-kost" style="font-size: 12px; color: #666; margin-top: 4px;">{{ $review->boardingHouse->name }}</p>
                    </div>
                    @empty
                    <!-- Default testimonials if no reviews from database -->
                    <div class="testimonial-card">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">
                            "Tinggal kos di TriniStay sangat nyaman. Kamar bersih, fasilitas lengkap, dan harga terjangkau. Sangat recommended untuk mahasiswa!"
                        </p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star empty">★</span>
                        </div>
                        <p class="reviewer-name">Penyewa TriniStay</p>
                    </div>

                    <div class="testimonial-card">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">
                            "Sistem pencarian teman sekamar sangat membantu! Saya menemukan roommate yang cocok dan kami jadi teman baik. TriniStay tidak hanya tempat tinggal, tapi juga tempat membangun persahabatan baru."
                        </p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <p class="reviewer-name">Penyewa TriniStay</p>
                    </div>

                    <div class="testimonial-card">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">
                            "Platform yang user-friendly dan proses booking sangat cepat. Dalam hitungan hari saya sudah bisa pindah ke kos baru. Recommended banget untuk mahasiswa yang butuh tempat tinggal nyaman!"
                        </p>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <p class="reviewer-name">Penyewa TriniStay</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if($reviews->count() > 3 || $reviews->isEmpty())
            <div class="testimonials-pagination">
                @php $totalSlides = $reviews->count() > 0 ? ceil($reviews->count() / 3) : 1; @endphp
                @for($i = 0; $i < max($totalSlides, 1); $i++)
                <span class="dot {{ $i === 0 ? 'active' : '' }}" data-testimonial-slide="{{ $i }}"></span>
                @endfor
            </div>
            @endif
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <div class="footer-logo">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>TriniStay</span>
                    </div>
                    <p class="footer-slogan">
                        Temukan hunian nyaman di Trini yang mendukung fokus belajar atau beristirahat.
                    </p>
                </div>

                <div class="footer-right">
                    <h3 class="footer-heading">Hubungi Kami</h3>
                    <div class="contact-info">
                        <p>Jl. Babarsari 2 , Jarno 04, 55281 Sleman, Suroganti, Caturtunggal, DIY.</p>
                    </div>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Email" class="email-input">
                        <button class="btn-subscribe">WhatsApp</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
