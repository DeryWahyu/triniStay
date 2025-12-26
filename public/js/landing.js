// ===========================
// TriniStay Landing Page JavaScript
// Modern & Professional Theme
// ===========================

// ===========================
// Navbar Scroll Effect
// ===========================
function initNavbar() {
    const navbar = document.getElementById('navbar');

    function updateNavbar() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', updateNavbar);
    updateNavbar();
}

// ===========================
// Mobile Menu Toggle
// ===========================
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            mobileMenuBtn.classList.toggle('active');
        });

        // Close menu when clicking on a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
            }
        });
    }
}

// ===========================
// Smooth Scroll for Navigation
// ===========================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const targetElement = document.querySelector(href);

            if (targetElement) {
                const navHeight = document.getElementById('navbar').offsetHeight;
                const targetPosition = targetElement.offsetTop - navHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===========================
// Property Filter Functionality
// ===========================
function initPropertyFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const propertyCards = document.querySelectorAll('.property-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            // Filter cards with animation
            propertyCards.forEach(card => {
                const cardType = card.dataset.type;

                if (filter === 'all' || cardType === filter) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// ===========================
// Wishlist Button Toggle
// ===========================
function initWishlist() {
    document.querySelectorAll('.btn-wishlist').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            btn.classList.toggle('active');

            if (btn.classList.contains('active')) {
                btn.querySelector('svg').style.fill = 'currentColor';
                btn.style.color = 'white';

                // Add pulse animation
                btn.style.animation = 'pulse 0.3s ease';
                setTimeout(() => {
                    btn.style.animation = '';
                }, 300);
            } else {
                btn.querySelector('svg').style.fill = 'none';
                btn.style.color = '';
            }
        });
    });
}

// ===========================
// Scroll Reveal Animation
// ===========================
function initScrollReveal() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Add reveal class to elements
    const revealElements = document.querySelectorAll(
        '.feature-card, .property-card, .testimonial-card, .about-feature'
    );

    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });

    // Style for revealed elements
    const style = document.createElement('style');
    style.textContent = `
        .revealed {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    `;
    document.head.appendChild(style);
}

// ===========================
// Counter Animation
// ===========================
function initCounterAnimation() {
    const counters = document.querySelectorAll('.stat-number');

    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const text = target.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                const suffix = text.replace(/[0-9]/g, '');

                animateCounter(target, number, suffix);
                observer.unobserve(target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
}

function animateCounter(element, target, suffix) {
    let current = 0;
    const increment = target / 50;
    const duration = 1500;
    const stepTime = duration / 50;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current) + suffix;
    }, stepTime);
}

// ===========================
// Search Box Functionality
// ===========================
function initSearchBox() {
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.querySelector('.search-input');

    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', () => {
            const query = searchInput.value.trim();
            if (query) {
                // Scroll to kos section
                const kosSection = document.getElementById('kos');
                if (kosSection) {
                    const navHeight = document.getElementById('navbar').offsetHeight;
                    window.scrollTo({
                        top: kosSection.offsetTop - navHeight - 20,
                        behavior: 'smooth'
                    });
                }

                // Highlight matching cards
                highlightSearchResults(query);
            }
        });

        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                searchBtn.click();
            }
        });
    }
}

function highlightSearchResults(query) {
    const cards = document.querySelectorAll('.property-card');
    const queryLower = query.toLowerCase();

    cards.forEach(card => {
        const name = card.querySelector('.property-name')?.textContent.toLowerCase() || '';
        const location = card.querySelector('.property-location span')?.textContent.toLowerCase() || '';

        if (name.includes(queryLower) || location.includes(queryLower)) {
            card.style.boxShadow = '0 0 0 3px var(--primary), var(--shadow-xl)';
            card.style.transform = 'translateY(-8px)';
        } else {
            card.style.opacity = '0.5';
        }
    });

    // Reset after 3 seconds
    setTimeout(() => {
        cards.forEach(card => {
            card.style.boxShadow = '';
            card.style.transform = '';
            card.style.opacity = '';
        });
    }, 3000);
}

// ===========================
// Parallax Effect for Hero
// ===========================
function initParallax() {
    const shapes = document.querySelectorAll('.floating-shape');

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.1;
            shape.style.transform = `translateY(${scrollY * speed}px)`;
        });
    });
}

// ===========================
// Lazy Loading Images
// ===========================
function initLazyLoading() {
    const images = document.querySelectorAll('img[loading="lazy"]');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.5s ease';
            imageObserver.observe(img);
        });

        const style = document.createElement('style');
        style.textContent = `
            img.loaded {
                opacity: 1 !important;
            }
        `;
        document.head.appendChild(style);
    }
}

// ===========================
// Typing Animation for Hero
// ===========================
function initTypingAnimation() {
    const heroTitle = document.querySelector('.hero-title');
    if (!heroTitle) return;

    // Already animated via CSS
}

// ===========================
// Add Pulse Animation CSS
// ===========================
function addAnimationStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .btn-wishlist.active {
            background: var(--accent) !important;
            color: white !important;
        }
        
        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
    `;
    document.head.appendChild(style);
}

// ===========================
// Initialize Everything
// ===========================
document.addEventListener('DOMContentLoaded', () => {
    // Core functionality
    initNavbar();
    initMobileMenu();
    initSmoothScroll();

    // Enhanced features
    initPropertyFilter();
    initWishlist();
    initScrollReveal();
    initCounterAnimation();
    initSearchBox();
    initLazyLoading();

    // Visual effects
    initParallax();
    addAnimationStyles();

    console.log('✨ TriniStay Landing Page Loaded Successfully!');
});

// ===========================
// Handle Page Visibility
// ===========================
document.addEventListener('visibilitychange', () => {
    const shapes = document.querySelectorAll('.floating-shape');
    shapes.forEach(shape => {
        shape.style.animationPlayState = document.hidden ? 'paused' : 'running';
    });
});

// ===========================
// Handle Window Resize
// ===========================
let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        // Recalculate layouts if needed
        initPropertyFilter();
    }, 250);
});
