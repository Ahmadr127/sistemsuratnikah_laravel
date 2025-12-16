@extends('layouts.app')

@section('title', $data['title'])

@section('content')
<!-- Hero Section -->
<section class="min-h-screen flex items-center bg-gradient-to-r from-primary to-secondary text-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 space-y-6" data-animate>
                <h1 class="text-5xl font-bold animate-fade-in-up">{{ $data['title'] }}</h1>
                <p class="text-xl animate-fade-in-up" style="animation-delay: 200ms">{{ $data['subtitle'] }}</p>
                <p class="text-lg opacity-90 animate-fade-in-up" style="animation-delay: 400ms">Sistem ADALAH ADALAH digital terdepan
                    untuk membuat buku nikah dengan verifikasi NIK
                    real-time. Proses yang mudah, cepat, dan aman untuk pernikahan Anda.</p>

                <!-- NIK Search Form -->
                <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm animate-fade-in-up"
                    style="animation-delay: 600ms">
                    <form action="{{ route('home') }}" method="GET" class="space-y-4">
                        <div class="flex flex-col space-y-2">
                            <label for="nik" class="text-white font-semibold">Cari Data Pernikahan</label>
                            <div class="relative">
                                <input type="text" name="nik" id="nik" placeholder="Masukkan NIK Anda..."
                                    class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300"
                                    required>
                                <button type="submit"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-white text-primary px-4 py-2 rounded-lg hover:bg-opacity-90 transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex flex-wrap gap-4 animate-fade-in-up" style="animation-delay: 800ms">
                    <a href="#features"
                        class="px-6 py-3 bg-white text-primary rounded-lg hover:bg-opacity-90 transition-all duration-300 hover:scale-105">
                        <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
                    </a>
                    <a href="#contact"
                        class="px-6 py-3 border-2 border-white rounded-lg hover:bg-white hover:text-primary transition-all duration-300 hover:scale-105">
                        <i class="fas fa-phone mr-2"></i>Hubungi Kami
                    </a>
                </div>
                <div class="lg:w-1/2 text-center mt-8 lg:mt-0">
                    <div class="relative">
                        <i class="fas fa-certificate text-[15rem] opacity-30"></i>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Features Section -->
<section id="features" class="min-h-screen flex items-center py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Fitur Unggulan</h2>
            <p class="text-xl text-gray-600">Kemudahan dan keamanan dalam satu platform</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($data['features'] as $feature)
            <div class="transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg p-6 h-full">
                    <div class="text-4xl text-primary mb-4">
                        <i class="{{ $feature['icon'] }}"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">{{ $feature['title'] }}</h4>
                    <p class="text-gray-600">{{ $feature['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-4xl font-bold mb-4 text-primary">Pencapaian Kami</h2>
            <p class="text-xl text-gray-600">Membantu ribuan pasangan dalam perjalanan pernikahan mereka</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group animate-fade-in-up" style="animation-delay: 200ms">
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-xl p-8 text-center transform transition-all duration-300 hover:scale-105 hover:rotate-2">
                    <div class="text-white mb-4">
                        <i class="fas fa-book-heart text-4xl animate-float"></i>
                    </div>
                    <span
                        class="text-4xl font-bold text-white block mb-2">{{ number_format($data['stats']['total_marriages']) }}</span>
                    <div class="text-blue-100">Buku Nikah Dibuat</div>
                </div>
            </div>
            <div class="group animate-fade-in-up" style="animation-delay: 400ms">
                <div
                    class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-xl p-8 text-center transform transition-all duration-300 hover:scale-105 hover:rotate-2">
                    <div class="text-white mb-4">
                        <i class="fas fa-heart text-4xl animate-float"></i>
                    </div>
                    <span
                        class="text-4xl font-bold text-white block mb-2">{{ number_format($data['stats']['happy_couples']) }}</span>
                    <div class="text-pink-100">Pasangan Bahagia</div>
                </div>
            </div>
            <div class="group animate-fade-in-up" style="animation-delay: 600ms">
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-xl p-8 text-center transform transition-all duration-300 hover:scale-105 hover:rotate-2">
                    <div class="text-white mb-4">
                        <i class="fas fa-calendar-check text-4xl animate-float"></i>
                    </div>
                    <span
                        class="text-4xl font-bold text-white block mb-2">{{ $data['stats']['years_experience'] }}+</span>
                    <div class="text-purple-100">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="group animate-fade-in-up" style="animation-delay: 800ms">
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-xl p-8 text-center transform transition-all duration-300 hover:scale-105 hover:rotate-2">
                    <div class="text-white mb-4">
                        <i class="fas fa-smile text-4xl animate-float"></i>
                    </div>
                    <span
                        class="text-4xl font-bold text-white block mb-2">{{ $data['stats']['satisfaction_rate'] }}%</span>
                    <div class="text-green-100">Tingkat Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="about" class="min-h-screen flex items-center py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Prosedur Pendaftaran Nikah</h2>
            <p class="text-xl text-gray-600">Langkah-langkah lengkap untuk pendaftaran pernikahan</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg p-6 h-full">
                    <div class="text-4xl text-primary mb-4 text-center">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4 text-center">1. Persiapan Dokumen</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>KTP kedua calon pengantin</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Kartu Keluarga</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Akta kelahiran</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Pas foto 2x3 dan 4x6</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Surat izin dari orang tua (jika di bawah 21 tahun)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg p-6 h-full">
                    <div class="text-4xl text-primary mb-4 text-center">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4 text-center">2. Verifikasi NIK</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Masukkan NIK kedua calon</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Verifikasi data otomatis</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Konfirmasi data pribadi</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Validasi status pernikahan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Pengecekan kelengkapan data</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg p-6 h-full">
                    <div class="text-4xl text-primary mb-4 text-center">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4 text-center">3. Pengisian Form N1-N4</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Form N1: Surat keterangan nikah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Form N2: Asal-usul calon pengantin</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Form N3: Persetujuan kedua calon</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Form N4: Surat keterangan orang tua</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Input data saksi pernikahan</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg p-6 h-full">
                    <div class="text-4xl text-primary mb-4 text-center">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4 text-center">4. Jadwal dan Buku Nikah</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Pemilihan tanggal akad</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Penentuan lokasi nikah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Pembayaran biaya nikah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Penerbitan buku nikah digital</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">•</span>
                            <span>Download buku nikah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-12">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                <div class="flex items-center text-blue-800 mb-2">
                    <i class="fas fa-info-circle text-xl mr-2"></i>
                    <h5 class="font-semibold text-lg">Penting Diketahui</h5>
                </div>
                <p class="text-blue-700">Pendaftaran nikah harus dilakukan minimal 10 hari kerja sebelum tanggal akad.
                    Pastikan semua dokumen telah dipersiapkan dengan lengkap untuk menghindari penundaan proses.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="start" class="py-20 bg-gradient-to-r from-primary to-secondary text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Memulai Perjalanan Pernikahan Anda?</h2>
            <p class="text-xl mb-8 opacity-90">Hubungi admin untuk membuat buku nikah digital Anda dengan mudah dan
                cepat. Proses yang aman dan terpercaya.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#contact"
                    class="px-8 py-3 bg-white text-primary rounded-lg hover:bg-opacity-90 transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>Hubungi Admin
                </a>
                <a href="#contact"
                    class="px-8 py-3 border-2 border-white rounded-lg hover:bg-white hover:text-primary transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<!-- KUA Locations Section -->
<section id="locations" class="min-h-screen flex items-center py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Lokasi KUA</h2>
            <p class="text-xl text-gray-600">Kantor Urusan Agama di wilayah kami</p>
        </div>

        @if($kuas->count() > 0)
        <div class="space-y-12">
            @foreach($kuas as $index => $kua)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 {{ $index % 2 == 1 ? 'lg:flex-row-reverse' : '' }}">
                <!-- Location Info Card -->
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 {{ $index % 2 == 1 ? 'lg:order-2' : '' }}">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <i class="fas fa-mosque text-3xl text-primary mr-4"></i>
                            <h5 class="text-2xl font-semibold">{{ $kua->name }}</h5>
                        </div>
                        <div class="space-y-4 text-gray-600">
                            <p class="flex items-start text-lg">
                                <i class="fas fa-map-marker-alt w-8 text-primary mt-1"></i>
                                <span>{{ $kua->address }}</span>
                            </p>
                            @if($kua->phone)
                            <p class="flex items-center text-lg">
                                <i class="fas fa-phone w-8 text-primary"></i>
                                <span>{{ $kua->phone }}</span>
                            </p>
                            @endif
                            @if($kua->email)
                            <p class="flex items-center text-lg">
                                <i class="fas fa-envelope w-8 text-primary"></i>
                                <span>{{ $kua->email }}</span>
                            </p>
                            @endif
                            @if($kua->operating_hours)
                            <p class="flex items-center text-lg">
                                <i class="fas fa-clock w-8 text-primary"></i>
                                <span>{{ $kua->operating_hours }}</span>
                            </p>
                            @endif
                        </div>
                        @if($kua->google_maps_link)
                        <div class="mt-8">
                            <a href="{{ $kua->google_maps_link }}"
                                class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105"
                                target="_blank">
                                <i class="fas fa-directions mr-2"></i>Petunjuk Arah ke Lokasi
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Google Maps Embed -->
                @if($kua->google_maps_embed)
                <div
                    class="rounded-xl shadow-lg overflow-hidden h-[500px] transform hover:-translate-y-2 transition-all duration-300 {{ $index % 2 == 1 ? 'lg:order-1' : '' }}">
                    <iframe
                        src="{{ $kua->google_maps_embed }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="transition-all duration-300 hover:opacity-90">
                    </iframe>
                </div>
                @endif
            </div>
            @if(!$loop->last)
            <hr class="my-12 border-gray-200">
            @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-mosque text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">Belum ada data KUA yang tersedia.</p>
        </div>
        @endif
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="min-h-screen flex items-center py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Hubungi Kami</h2>
            <p class="text-xl text-gray-600">Ada pertanyaan? Tim kami siap membantu Anda</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h4 class="text-2xl font-semibold mb-6">Informasi Kontak</h4>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="text-2xl text-primary mr-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-semibold">Email</h5>
                            <p class="text-gray-600">info@bukunikahdigital.com</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="text-2xl text-primary mr-4">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-semibold">Telepon</h5>
                            <p class="text-gray-600">+62 123 456 7890</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="text-2xl text-primary mr-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-semibold">Jam Operasional</h5>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea id="message" rows="4" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
// Create section indicator
const sections = document.querySelectorAll('section[id]');
const indicator = document.createElement('div');
indicator.className = 'fixed right-4 top-1/2 transform -translate-y-1/2 z-50 hidden lg:block';
document.body.appendChild(indicator);

// Add indicator dots
sections.forEach(section => {
    const dot = document.createElement('a');
    dot.href = `#${section.id}`;
    dot.setAttribute('data-section', section.id);
    dot.className = 'block w-3 h-3 mb-3 rounded-full bg-gray-300 hover:bg-primary transition-all duration-300';
    indicator.appendChild(dot);
});

// Smooth scrolling with offset
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerOffset = 80;
            const elementPosition = target.offsetTop;
            const offsetPosition = elementPosition - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Update active section in indicator
function updateActiveSection() {
    const scrollPosition = window.scrollY;

    sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        const sectionBottom = sectionTop + section.offsetHeight;
        const dot = indicator.querySelector(`[data-section="${section.id}"]`);

        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            dot.classList.remove('bg-gray-300');
            dot.classList.add('bg-primary', 'scale-150');
        } else {
            dot.classList.add('bg-gray-300');
            dot.classList.remove('bg-primary', 'scale-150');
        }
    });
}

// Listen for scroll events
window.addEventListener('scroll', updateActiveSection);
updateActiveSection();

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.remove('opacity-0', 'translate-y-8');
            entry.target.classList.add('opacity-100', 'translate-y-0');
        }
    });
}, observerOptions);

// Observe all animated elements
document.querySelectorAll('[data-animate]').forEach(el => {
    el.classList.add('transform', 'transition-all', 'duration-700', 'opacity-0', 'translate-y-8');
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
}, {
    threshold: 0.5
});

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    statsObserver.observe(statsSection);
}
</script>
@endsection