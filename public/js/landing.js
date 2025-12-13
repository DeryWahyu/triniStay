// ===========================
// Property Carousel Functionality
// ===========================
class PropertyCarousel {
    constructor() {
        this.container = document.querySelector('.carousel-container');
        this.dots = document.querySelectorAll('.carousel-pagination .dot');
        this.cards = document.querySelectorAll('.property-card');
        this.currentSlide = 0;
        this.cardsPerView = this.getCardsPerView();
        this.totalSlides = Math.ceil(this.cards.length / this.cardsPerView);

        this.init();
    }

    getCardsPerView() {
        const width = window.innerWidth;
        if (width > 1024) return 3;
        if (width > 768) return 2;
        return 1;
    }

    init() {
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Auto-play carousel
        this.autoPlay = setInterval(() => this.nextSlide(), 5000);

        // Pause on hover
        if (this.container) {
            this.container.addEventListener('mouseenter', () => this.pauseAutoPlay());
            this.container.addEventListener('mouseleave', () => this.resumeAutoPlay());
        }

        // Handle window resize
        window.addEventListener('resize', () => this.handleResize());
    }

    goToSlide(slideIndex) {
        this.currentSlide = slideIndex;
        this.updateCarousel();
    }

    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        this.updateCarousel();
    }

    updateCarousel() {
        const cardWidth = this.cards[0].offsetWidth;
        const gap = 30;
        const offset = -(this.currentSlide * this.cardsPerView * (cardWidth + gap));

        if (this.container) {
            this.container.style.transform = `translateX(${offset}px)`;
        }

        this.dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentSlide);
        });
    }

    pauseAutoPlay() {
        clearInterval(this.autoPlay);
    }

    resumeAutoPlay() {
        this.autoPlay = setInterval(() => this.nextSlide(), 5000);
    }

    handleResize() {
        const newCardsPerView = this.getCardsPerView();
        if (newCardsPerView !== this.cardsPerView) {
            this.cardsPerView = newCardsPerView;
            this.totalSlides = Math.ceil(this.cards.length / this.cardsPerView);
            this.currentSlide = 0;
            this.updateCarousel();
        }
    }
}

// ===========================
// Testimonials Carousel Functionality
// ===========================
class TestimonialsCarousel {
    constructor() {
        this.container = document.querySelector('.testimonials-container');
        this.dots = document.querySelectorAll('.testimonials-pagination .dot');
        this.cards = document.querySelectorAll('.testimonial-card');
        this.currentSlide = 0;
        this.cardsPerView = this.getCardsPerView();
        this.totalSlides = Math.ceil(this.cards.length / this.cardsPerView);

        this.init();
    }

    getCardsPerView() {
        const width = window.innerWidth;
        if (width > 1024) return 3;
        if (width > 768) return 2;
        return 1;
    }

    init() {
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Auto-play carousel
        this.autoPlay = setInterval(() => this.nextSlide(), 6000);

        // Pause on hover
        if (this.container) {
            this.container.addEventListener('mouseenter', () => this.pauseAutoPlay());
            this.container.addEventListener('mouseleave', () => this.resumeAutoPlay());
        }

        // Handle window resize
        window.addEventListener('resize', () => this.handleResize());
    }

    goToSlide(slideIndex) {
        this.currentSlide = slideIndex;
        this.updateCarousel();
    }

    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        this.updateCarousel();
    }

    updateCarousel() {
        const cardWidth = this.cards[0].offsetWidth;
        const gap = 30;
        const offset = -(this.currentSlide * this.cardsPerView * (cardWidth + gap));

        if (this.container) {
            this.container.style.transform = `translateX(${offset}px)`;
        }

        this.dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentSlide);
        });
    }

    pauseAutoPlay() {
        clearInterval(this.autoPlay);
    }

    resumeAutoPlay() {
        this.autoPlay = setInterval(() => this.nextSlide(), 6000);
    }

    handleResize() {
        const newCardsPerView = this.getCardsPerView();
        if (newCardsPerView !== this.cardsPerView) {
            this.cardsPerView = newCardsPerView;
            this.totalSlides = Math.ceil(this.cards.length / this.cardsPerView);
            this.currentSlide = 0;
            this.updateCarousel();
        }
    }
}

// ===========================
// Smooth Scroll for Navigation
// ===========================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const navHeight = document.querySelector('.navbar').offsetHeight;
                const targetPosition = targetElement.offsetTop - navHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===========================
// Navbar Scroll Effect
// ===========================
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            navbar.style.background = 'rgba(31, 41, 55, 0.95)';
            navbar.style.backdropFilter = 'blur(10px)';
            navbar.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        } else {
            navbar.style.background = 'transparent';
            navbar.style.backdropFilter = 'none';
            navbar.style.boxShadow = 'none';
        }

        lastScroll = currentScroll;
    });
}

// ===========================
// Scroll Animation for Sections
// ===========================
function initScrollAnimation() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe sections
    document.querySelectorAll('section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
}

// ===========================
// Detail Button Click Handler
// ===========================
function initDetailButtons() {
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            const propertyName = this.closest('.property-card')
                .querySelector('.property-name').textContent;
            alert(`Fitur detail untuk "${propertyName}" akan segera tersedia!`);
        });
    });
}

// ===========================
// Newsletter Form Handler
// ===========================
function initNewsletterForm() {
    const subscribeBtn = document.querySelector('.btn-subscribe');
    const emailInput = document.querySelector('.email-input');

    if (subscribeBtn && emailInput) {
        subscribeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const email = emailInput.value.trim();

            if (email === '') {
                alert('Silakan masukkan email Anda');
                return;
            }

            // Simple email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid');
                return;
            }

            // WhatsApp redirect
            const message = encodeURIComponent(`Halo, saya tertarik dengan TriniStay. Email saya: ${email}`);
            window.open(`https://wa.me/6281234567890?text=${message}`, '_blank');

            emailInput.value = '';
        });
    }
}

// ===========================
// Initialize All Features
// ===========================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize carousels
    new PropertyCarousel();
    new TestimonialsCarousel();

    // Initialize other features
    initSmoothScroll();
    initNavbarScroll();
    initScrollAnimation();
    initDetailButtons();
    initLoginButton();
    initNewsletterForm();

    console.log('TriniStay landing page loaded successfully!');
});

// ===========================
// Handle Page Visibility Change
// ===========================
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Pause animations when page is not visible
        document.querySelectorAll('.carousel-container, .testimonials-container').forEach(container => {
            container.style.animationPlayState = 'paused';
        });
    } else {
        // Resume animations when page is visible
        document.querySelectorAll('.carousel-container, .testimonials-container').forEach(container => {
            container.style.animationPlayState = 'running';
        });
    }
});
