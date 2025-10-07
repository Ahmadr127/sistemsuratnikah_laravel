<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistem Buku Nikah Digital')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#2c3e50',
                    secondary: '#3498db',
                    accent: '#e74c3c',
                    success: '#27ae60',
                    warning: '#f39c12'
                }
            },
            fontFamily: {
                sans: ['Poppins', 'sans-serif']
            }
        }
    }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
    /* Add padding to body to accommodate fixed navbar */
    body {
        padding-top: 4rem;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes floatAnimation {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-scale-in {
        opacity: 0;
        animation: scaleIn 0.5s ease-out forwards;
    }

    .animate-float {
        animation: floatAnimation 3s ease-in-out infinite;
    }

    /* Hover effects */
    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Custom transition for mobile menu */
    .mobile-menu-enter {
        opacity: 0;
        transform: scale(0.95);
    }

    .mobile-menu-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 300ms ease-out, transform 300ms ease-out;
    }

    .mobile-menu-exit {
        opacity: 1;
        transform: scale(1);
    }

    .mobile-menu-exit-active {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 300ms ease-in, transform 300ms ease-in;
    }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Navigation -->
    <nav x-data="{ isScrolled: false, isOpen: false }" class="fixed w-full top-0 z-50 transition-all duration-300"
        :class="{ 'bg-gradient-to-r from-primary to-secondary shadow-lg': true, 'py-2': isScrolled, 'py-4': !isScrolled }"
        @scroll.window="isScrolled = (window.pageYOffset > 20)">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a class="text-white text-xl font-semibold flex items-center transition-all duration-300 group"
                    :class="{ 'transform scale-90': isScrolled }" href="{{ route('home') }}">
                    <div
                        class="bg-white/10 w-10 h-10 rounded-xl flex items-center justify-center mr-3 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-heart text-lg"></i>
                    </div>
                    <span>Buku Nikah Digital</span>
                </a>

                <button
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-colors"
                    @click="isOpen = !isOpen">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="hidden lg:flex items-center" id="navbar-menu"
                    :class="{ 'hidden': !isOpen, 'block': isOpen }">
                    <ul class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-1">
                        <li>
                            <a class="px-4 py-2 text-white/90 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300 inline-flex items-center"
                                href="{{ route('home') }}">
                                <i class="fas fa-home w-5 mr-2"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-white/90 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300 inline-flex items-center"
                                href="#features">
                                <i class="fas fa-star w-5 mr-2"></i>
                                <span>Fitur</span>
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-white/90 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300 inline-flex items-center"
                                href="#about">
                                <i class="fas fa-info-circle w-5 mr-2"></i>
                                <span>Tentang</span>
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-white/90 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300 inline-flex items-center"
                                href="#contact">
                                <i class="fas fa-envelope w-5 mr-2"></i>
                                <span>Kontak</span>
                            </a>
                        </li>

                        @auth
                        <li class="relative ml-2" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 px-4 py-2 text-white/90 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300 focus:outline-none">
                                <div class="relative">
                                    <img class="h-8 w-8 rounded-lg object-cover"
                                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                        alt="{{ Auth::user()->name }}">
                                    @if(Auth::user()->isAdmin())
                                    <div
                                        class="absolute -top-1 -right-1 h-3 w-3 bg-yellow-400 rounded-full border-2 border-blue-600">
                                    </div>
                                    @endif
                                </div>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">

                                <div class="px-4 py-3">
                                    <p class="text-sm text-gray-900">Logged in as</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>

                                <div class="py-1">
                                    @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-chart-line w-5 mr-3 text-gray-400"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    @endif
                                </div>

                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors">
                                            <i class="fas fa-sign-out-alt w-5 mr-3 text-red-400"></i>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @else
                        <li class="ml-2">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-4 py-2 bg-white/10 text-white border border-white/20 rounded-xl hover:bg-white/20 transition-all duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                <span>Masuk</span>
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h5 class="text-xl font-bold flex items-center">
                        <i class="fas fa-heart mr-2"></i>Buku Nikah Digital
                    </h5>
                    <p class="mt-3 text-gray-300">Sistem digital untuk membuat buku nikah dengan mudah, cepat, dan
                        terpercaya.</p>
                </div>
                <div class="md:text-right">
                    <h6 class="text-lg font-semibold">Kontak Kami</h6>
                    <p class="mt-2 text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>info@bukunikahdigital.com<br>
                        <i class="fas fa-phone mr-2"></i>+62 123 456 7890
                    </p>
                </div>
            </div>
            <hr class="my-6 border-gray-600">
            <div class="text-center text-gray-300">
                <p>&copy; {{ date('Y') }} Buku Nikah Digital. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdown functionality -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
    // Initialize scroll behavior
    document.addEventListener('alpine:init', () => {
        Alpine.store('nav', {
            scrolled: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.pageYOffset > 20;
                });
            }
        });
    });

    // Smooth scroll for anchor links
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
    </script>

    @yield('scripts')
</body>

</html>