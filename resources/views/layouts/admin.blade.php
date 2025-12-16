<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard - Buku Nikah Digital')</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @yield('styles')
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: true }" class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 z-40 h-screen transition-transform duration-300 ease-in-out transform"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen}">
            <div class="h-full w-64 bg-gradient-to-b from-blue-600 to-blue-800 relative shadow-xl">
                <!-- Overlay untuk mobile -->
                <div class="lg:hidden fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300"
                     x-show="sidebarOpen"
                     x-transition:enter="transition-opacity ease-in duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-out duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="sidebarOpen = false">
                </div>

                <!-- Logo -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-blue-500/30">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="bg-white/10 p-2 rounded-lg transition-all duration-300 group-hover:bg-white/20">
                            <i class="fas fa-heart text-2xl text-white"></i>
                        </div>
                        <span class="text-white font-semibold text-lg transition-all duration-300 group-hover:text-blue-200">
                            Buku Nikah Digital
                        </span>
                    </a>
                    <button @click="sidebarOpen = false" 
                            class="lg:hidden text-white/70 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Admin Info -->
                <div class="px-4 py-3 mb-6 bg-white/10 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <img class="w-10 h-10 rounded-full border-2 border-white" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                             alt="{{ Auth::user()->name }}">
                        <div>
                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-300">Administrator</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-3 py-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="group flex items-center px-4 py-3 text-white/90 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center flex-1">
                            <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-chart-line text-lg"></i>
                            </div>
                            <span class="ml-3 font-medium">Dashboard</span>
                        </div>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('admin.marriages*') || request()->routeIs('admin.marriage.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" 
                                class="group flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-300 hover:bg-white/10">
                            <div class="flex items-center flex-1">
                                <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                                    <i class="fas fa-heart text-lg"></i>
                                </div>
                                <span class="ml-3 font-medium">Pernikahan</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300" 
                               :class="{'rotate-180': open}"></i>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition-all duration-300 ease-in-out" 
                             x-transition:enter-start="opacity-0 max-h-0" 
                             x-transition:enter-end="opacity-100 max-h-96"
                             x-transition:leave="transition-all duration-300 ease-in-out"
                             x-transition:leave-start="opacity-100 max-h-96"
                             x-transition:leave-end="opacity-0 max-h-0"
                             class="pl-14 space-y-1 overflow-hidden">
                            <a href="{{ route('admin.marriages') }}" 
                                class="group flex items-center px-4 py-2 text-white/80 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.marriages') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                                <i class="fas fa-list w-5 transition-transform duration-300 group-hover:scale-110"></i>
                                <span class="ml-3">Daftar Pernikahan</span>
                            </a>
                            <a href="{{ route('admin.marriage.create') }}" 
                                class="group flex items-center px-4 py-2 text-white/80 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.marriage.create') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                                <i class="fas fa-plus w-5 transition-transform duration-300 group-hover:scale-110"></i>
                                <span class="ml-3">Buat Buku Nikah</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.users') }}" 
                        class="group flex items-center px-4 py-3 text-white/90 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center flex-1">
                            <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 {{ request()->routeIs('admin.users') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <span class="ml-3 font-medium">Kelola Pengguna</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.ktp-data') }}" 
                        class="group flex items-center px-4 py-3 text-white/90 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.ktp-data') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center flex-1">
                            <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 {{ request()->routeIs('admin.ktp-data') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-id-card text-lg"></i>
                            </div>
                            <span class="ml-3 font-medium">Data KTP</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.kuas.index') }}" 
                        class="group flex items-center px-4 py-3 text-white/90 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.kuas.*') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center flex-1">
                            <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 {{ request()->routeIs('admin.kuas.*') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-mosque text-lg"></i>
                            </div>
                            <span class="ml-3 font-medium">Kelola KUA</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.home-settings.edit') }}" 
                        class="group flex items-center px-4 py-3 text-white/90 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.home-settings.edit') ? 'bg-white/20 shadow-lg shadow-blue-500/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center flex-1">
                            <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 {{ request()->routeIs('admin.home-settings.edit') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-cog text-lg"></i>
                            </div>
                            <span class="ml-3 font-medium">Pengaturan Home</span>
                        </div>
                    </a>

                    <!-- Logout Button -->
                    <div class="px-3 pt-4 mt-4 border-t border-blue-500/30">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="group flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-300 hover:bg-red-500/20">
                                <div class="flex items-center flex-1">
                                    <div class="bg-white/10 w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:bg-red-500/20">
                                        <i class="fas fa-sign-out-alt text-lg group-hover:text-red-200"></i>
                                    </div>
                                    <span class="ml-3 font-medium group-hover:text-red-200">Keluar</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="min-h-screen transition-all duration-300" 
             :class="{'lg:pl-64': true}">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="max-w-screen-2xl mx-auto">
                    <div class="flex items-center justify-between px-4 py-4">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = !sidebarOpen" 
                                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all duration-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <span class="ml-4 text-lg font-medium text-gray-800">@yield('page_title', 'Dashboard')</span>
                        </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" 
                           class="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-primary transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            <span>Beranda</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="max-w-screen-2xl mx-auto px-4 py-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>

    @yield('scripts')
</body>
</html>