
@extends('layouts.app')

@section('title', $data['title'])

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="display-4 fw-bold mb-4">{{ $data['title'] }}</h1>
                <p class="lead mb-4">{{ $data['subtitle'] }}</p>
                <p class="mb-4">Sistem digital terdepan untuk membuat buku nikah dengan verifikasi NIK real-time. Proses yang mudah, cepat, dan aman untuk pernikahan Anda.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#features" class="btn btn-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <i class="fas fa-certificate" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">Kemudahan dan keamanan dalam satu platform</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($data['features'] as $feature)
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="{{ $feature['icon'] }}"></i>
                    </div>
                    <h4 class="mb-3">{{ $feature['title'] }}</h4>
                    <p class="text-muted">{{ $feature['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Pencapaian Kami</h2>
                <p class="section-subtitle">Membantu ribuan pasangan dalam perjalanan pernikahan mereka</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">{{ number_format($data['stats']['total_marriages']) }}</span>
                    <div class="stat-label">Buku Nikah Dibuat</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">{{ number_format($data['stats']['happy_couples']) }}</span>
                    <div class="stat-label">Pasangan Bahagia</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $data['stats']['years_experience'] }}+</span>
                    <div class="stat-label">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $data['stats']['satisfaction_rate'] }}%</span>
                    <div class="stat-label">Tingkat Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Cara Kerja</h2>
                <p class="section-subtitle">Proses yang sederhana dalam 3 langkah mudah</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h4>1. Verifikasi NIK</h4>
                    <p class="text-muted">Masukkan NIK calon pengantin untuk verifikasi data secara real-time</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h4>2. Isi Data Pernikahan</h4>
                    <p class="text-muted">Lengkapi informasi pernikahan dan data saksi pernikahan</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-download"></i>
                    </div>
                    <h4>3. Download Buku Nikah</h4>
                    <p class="text-muted">Buku nikah digital siap diunduh dalam format PDF</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="start" class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Siap Memulai Perjalanan Pernikahan Anda?</h2>
                <p class="lead mb-4">Hubungi admin untuk membuat buku nikah digital Anda dengan mudah dan cepat. Proses yang aman dan terpercaya.</p>
                <a href="#contact" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-phone me-2"></i>Hubungi Admin
                </a>
                <a href="#contact" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle">Ada pertanyaan? Tim kami siap membantu Anda</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p class="text-muted">info@bukunikahdigital.com</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Telepon</h5>
                        <p class="text-muted">+62 123 456 7890</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5>Jam Operasional</h5>
                        <p class="text-muted">Senin - Jumat: 08:00 - 17:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all feature cards and stat items
    document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Counter animation for stats
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        function updateCounter() {
            start += increment;
            if (start < target) {
                element.textContent = Math.floor(start).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        }
        
        updateCounter();
    }

    // Trigger counter animation when stats section is visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach((stat, index) => {
                    const target = parseInt(stat.textContent.replace(/[^\d]/g, ''));
                    setTimeout(() => {
                        animateCounter(stat, target);
                    }, index * 200);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

</script>
@endsection
