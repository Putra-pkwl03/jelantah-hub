<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JelantahHub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- =========================================================================
             ASET GLOBAL MAPS ENGINE (LEAFLET.JS) - UNTUK VISUALISASI DI DASHBOARD
             ========================================================================= -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50" x-data="{ sidebarExpanded: true, mobileSidebarOpen: false }">
        <div class="min-h-screen flex flex-col md:flex-row relative">

            <x-sidebar-desktop />

            <x-sidebar-mobile />

            <div 
                :class="sidebarExpanded ? 'md:pl-64' : 'md:pl-20'" 
                class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out w-full">
                
                <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-10 shadow-sm">
                    <div class="flex items-center gap-4">
                        <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        @isset($header)
                            <div>{{ $header }}</div>
                        @endisset
                    </div>

                    <div class="flex items-center gap-4" x-data="{ openProfileMenu: false }">
                        <div class="relative">
                            <button @click="openProfileMenu = !openProfileMenu" @click.outside="openProfileMenu = false" class="flex items-center gap-3 text-left focus:outline-none p-1 rounded-lg hover:bg-slate-50 transition-colors">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] font-medium text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-green-100 border border-green-200 text-green-700 flex items-center justify-center font-bold text-sm uppercase">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                            </button>

                            <div x-show="openProfileMenu" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-slate-200 shadow-lg py-1 z-999 raw-dropdown"
                                 style="display: none;">
                                
                                <div class="px-4 py-2 border-b border-slate-100 md:hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] font-medium text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Edit Profil
                                </a>

                                <hr class="border-slate-100 my-1">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left transition-colors">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                        Keluar Aplikasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>