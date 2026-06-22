<aside 
    :class="sidebarExpanded ? 'w-64' : 'w-20'" 
    class="hidden md:flex flex-col fixed inset-y-0 left-0 bg-white text-zinc-600 transition-all duration-300 ease-in-out z-30 border-r border-zinc-200 shadow-sm overflow-hidden">
    
    <div 
        @click="!sidebarExpanded ? sidebarExpanded = true : null"
        :class="!sidebarExpanded ? 'justify-center px-0 cursor-pointer hover:bg-zinc-100/60' : 'justify-between px-4'"
        class="h-16 flex items-center bg-zinc-50/50 border-b border-zinc-100 overflow-hidden shrink-0 transition-all duration-300 select-none">
        
        <div class="flex items-center gap-3 overflow-hidden shrink-0">
            <div :class="!sidebarExpanded ? 'hover:scale-105 active:scale-95' : ''"
                 class="w-9 h-9 rounded-xl overflow-hidden shrink-0 shadow-sm border border-zinc-200/50 transition-all duration-200">
                <img src="{{ asset('images/logo.png') }}" alt="Logo JetOil" class="w-full h-full object-cover">
            </div>
            
            <div class="flex flex-col tracking-tight" x-show="sidebarExpanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <span class="font-bold text-sm text-zinc-800 tracking-wide">JetOil</span>
                <span class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider -mt-0.5">{{ Auth::user()->role }}</span>
            </div>
        </div>

        <button 
            x-show="sidebarExpanded"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            @click.stop="sidebarExpanded = false" 
            class="p-1.5 rounded-lg text-zinc-400 hover:bg-zinc-100 hover:text-zinc-700 transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 p-3 space-y-1.5 overflow-y-auto no-scrollbar overflow-x-hidden">
        
        {{-- ==================== MENU ROLE: MASYARAKAT ==================== --}}
        @if(Auth::user()->role === 'masyarakat')
            
            <a href="{{ route('masyarakat.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('masyarakat.dashboard') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('masyarakat.dashboard') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Dashboard Utama</span>
            </a>

            <a href="{{ route('masyarakat.pengepul.terdekat') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('masyarakat.pengepul.terdekat') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('masyarakat.pengepul.terdekat') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Cari Pengepul</span>
            </a>

            <a href="{{ route('masyarakat.riwayat') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('masyarakat.riwayat') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('masyarakat.riwayat') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Riwayat Setoran</span>
            </a>

        {{-- ==================== MENU ROLE: PENGEPUL ==================== --}}
        @elseif(Auth::user()->role === 'pengepul')

            <a href="{{ route('pengepul.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('pengepul.dashboard') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('pengepul.dashboard') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Dashboard Pengepul</span>
            </a>

            <a href="{{ route('pengepul.harga.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('pengepul.harga.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('pengepul.harga.*') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Atur Harga Beli</span>
            </a>

            <a href="{{ route('pengepul.setoran.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('pengepul.setoran.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('pengepul.setoran.*') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Setoran Masyarakat</span>
            </a>

            <a href="{{ route('pengepul.pengiriman.create') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('pengepul.pengiriman.create') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('pengepul.pengiriman.create') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM19.5 18.75a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-7.408-3.75a3 3 0 0 0-5.592 0M13.5 10.5H21V14.25M13.5 10.5V7.5H4.5v11.25m11.25-1.125h.008v.008h-.008V17.25Zm3.75 0h.008v.008h-.008V17.25Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Kirim ke PT HEN</span>
            </a>

            <a href="{{ route('pengepul.pengiriman.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('pengepul.pengiriman.index') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('pengepul.pengiriman.index') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v1.243m4.5-1.243v1.243M3.878 19.122A12.04 12.04 0 0 1 12 18c2.907 0 5.56.1.037.3l.972.1-.215 1.132A10.5 10.5 0 1 0 12 3a10.5 10.5 0 0 0-8.122 16.122Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v4.5m0 0 3 3m-3-3-3 3" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Riwayat & Hasil Lab</span>
            </a>

        {{-- ==================== MENU ROLE: STAKEHOLDER (PT HEN) ==================== --}}
        @else

            <a href="{{ route('stakeholder.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('stakeholder.dashboard') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('stakeholder.dashboard') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Dashboard Ringkasan</span>
            </a>

            <a href="{{ route('stakeholder.harga.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('stakeholder.harga.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('stakeholder.harga.*') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9s2.015-9 4.5-9m0 0a9.015 9.015 0 015.659 2M12 3a9.015 9.015 0 00-5.659 2" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Harga & Lokasi HEN</span>
            </a>

            <a href="{{ route('stakeholder.pengiriman.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all group overflow-hidden {{ request()->routeIs('stakeholder.pengiriman.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'font-medium hover:bg-zinc-50 text-zinc-500 hover:text-zinc-800' }}">
                <span class="shrink-0 {{ request()->routeIs('stakeholder.pengiriman.*') ? 'text-emerald-600' : 'text-zinc-400 group-hover:text-zinc-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2Z" />
                    </svg>
                </span>
                <span x-show="sidebarExpanded" class="whitespace-nowrap items-center">Validasi & Uji Lab</span>
            </a>

        @endif

    </nav>

    <div class="p-4 border-t border-zinc-100 bg-zinc-50/50 hidden md:block shrink-0 overflow-hidden">
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" 
                class="w-full flex items-center justify-center rounded-xl text-sm font-bold bg-rose-50 hover:bg-rose-100 text-rose-600 transition-all h-10 px-3 active:scale-[0.98] overflow-hidden group">
                
                <span class="shrink-0 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                </span>
                
                <span x-show="sidebarExpanded" 
                      x-transition:enter="transition ease-out duration-150" 
                      x-transition:enter-start="opacity-0" 
                      x-transition:enter-end="opacity-100" 
                      class="ml-3 whitespace-nowrap">
                      Keluar Sistem
                </span>
            </button>
        </form>
    </div>
</aside>