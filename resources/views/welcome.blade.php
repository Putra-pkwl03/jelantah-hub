<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JetOil - PT Hijau Energi Nusantara</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Alpine.js untuk Interaktivitas (Mobile Menu & Kalkulator) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            [x-cloak] { display: none !important; }
            /* Custom utility untuk menyembunyikan scrollbar */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body x-data="{ mobileMenuOpen: false }" class="antialiased bg-zinc-50 text-zinc-800 selection:bg-emerald-500 selection:text-white">
        
        <!-- NAVBAR -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-zinc-100 transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 shadow-md shadow-emerald-200">
        <img src="{{ asset('images/logo.png') }}" alt="Logo JetOil" class="w-full h-full object-cover">
    </div>
    <div>
        <span class="text-base font-extrabold tracking-tight text-zinc-900 block leading-none">JetOil</span>
        <span class="text-[10px] text-emerald-600 font-bold tracking-wider uppercase">PT Hijau Energi Nusantara</span>
    </div>
</div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#fitur" class="text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Fitur Unggulan</a>
                    <a href="#alur" class="text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Alur Rantai Pasok</a>
                    <a href="#kalkulator" class="text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Simulasi Pendapatan</a>
                    <a href="#faq" class="text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">FAQ</a>
                </nav>

                <!-- Auth Buttons -->
                @if (Route::has('login'))
                    <div class="hidden md:flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 rounded-xl transition-all shadow-md shadow-emerald-100">
                                Dashboard Sistem
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-zinc-600 hover:text-emerald-600 transition-colors">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-zinc-900 hover:bg-zinc-800 active:scale-95 rounded-xl transition-all shadow-sm">
                                    Mulai Berkontribusi
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <!-- Hamburger Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl md:hidden text-zinc-600 hover:bg-zinc-100 transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-zinc-100 bg-white px-4 pt-4 pb-6 space-y-3 shadow-inner">
                <a @click="mobileMenuOpen = false" href="#fitur" class="block py-2 text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Fitur Unggulan</a>
                <a @click="mobileMenuOpen = false" href="#alur" class="block py-2 text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Alur Rantai Pasok</a>
                <a @click="mobileMenuOpen = false" href="#kalkulator" class="block py-2 text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">Simulasi Pendapatan</a>
                <a @click="mobileMenuOpen = false" href="#faq" class="block py-2 text-sm font-semibold text-zinc-600 hover:text-emerald-600 transition-colors">FAQ</a>
                <hr class="border-zinc-100 my-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center block px-4 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl">Dashboard Sistem</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center block px-4 py-3 text-sm font-bold text-zinc-700 bg-zinc-100 rounded-xl mb-2">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center block px-4 py-3 text-sm font-bold text-white bg-zinc-900 rounded-xl">Mulai Berkontribusi</a>
                @endauth
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="pt-36 pb-20 overflow-hidden relative min-h-[90vh] flex items-center">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-50 via-zinc-50 to-zinc-50 -z-10"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100/70 text-emerald-800 text-xs font-bold mb-6 tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sustainable Aviation Fuel (SAF) Ecosystem
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-zinc-900 tracking-tight leading-[1.1] mb-6">
                        Ubah Minyak Jelantah Menjadi <span class="text-emerald-600 relative inline-block">Energi Hijau<span class="absolute bottom-1 left-0 w-full h-2 bg-emerald-100 -z-10"></span></span> Penerbangan
                    </h1>
                    
                    <p class="text-base sm:text-lg text-zinc-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Platform transparansi rantai pasok digital untuk mengumpulkan, memvalidasi mutu uji laboratorium, dan menyalurkan bahan baku avtur ramah lingkungan di Indonesia.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto sm:max-w-none">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-all shadow-lg shadow-emerald-200 active:scale-98">
                            Daftar Sebagai Penyetor
                        </a>
                        <a href="#alur" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-zinc-700 bg-white border border-zinc-200 hover:bg-zinc-50 rounded-xl transition-all active:scale-98">
                            Pelajari Alur Supply Chain
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS COUNTER -->
        <section class="py-12 bg-white border-y border-zinc-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 text-center">
                    <div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-zinc-900 mb-1">98.4%</div>
                        <div class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Akurasi Prediksi Dana AI</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-zinc-900 mb-1">Haversine</div>
                        <div class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Matriks Jarak Terdekat</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-zinc-900 mb-1">Real-Time</div>
                        <div class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Validasi Berjenjang</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-zinc-900 mb-1">3 Peran</div>
                        <div class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Ekosistem Terintegrasi</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BENTO GRID FEATURES -->
        <section id="fitur" class="py-24 bg-zinc-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-zinc-900 tracking-tight sm:text-4xl mb-4">Teknologi Penyokong Transparansi Global</h2>
                    <p class="text-zinc-600 font-medium">JetOil dilengkapi standar teknologi mutakhir guna menggaransi akurasi data pengiriman dari hulu ke hilir.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1: Haversine Formula -->
                    <div class="bg-white p-8 rounded-2xl border border-zinc-200/60 shadow-sm md:col-span-2 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl text-emerald-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900 mb-2">Pencarian Jarak Akurat (Haversine Formula)</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed">Masyarakat dapat melacak koordinat lintang (*latitude*) dan bujur (*longitude*) untuk menemukan pos penampungan pengepul terdekat secara presisi, memotong rantai logistik yang tidak efisien.</p>
                        </div>
                        <div class="mt-6 text-xs font-bold text-emerald-600 uppercase tracking-wider">Terintegrasi Geolocation Peta</div>
                    </div>

                    <!-- Feature 2: Uji Lab Mutu -->
                    <div class="bg-white p-8 rounded-2xl border border-zinc-200/60 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-blue-50 rounded-xl text-blue-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v1.243m4.5-1.243v1.243M3.878 19.122A12.04 12.04 0 0 1 12 18c2.907 0 5.56.1.037.3l.972.1-.215 1.132A10.5 10.5 0 1 0 12 3a10.5 10.5 0 0 0-8.122 16.122Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v4.5m0 0 3 3m-3-3-3 3"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900 mb-2">Laboratorium Mutu QC</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed">Setiap pasokan minyak dipindai parameternya meliputi kadar air, FFA (*Free Fatty Acid*), dan kotoran sebelum dilebur menjadi avtur penerbangan.</p>
                        </div>
                        <div class="mt-6 text-xs font-bold text-blue-600 uppercase tracking-wider">Uji Standar SAF Global</div>
                    </div>

                    <!-- Feature 3: Analisis AI -->
                    <div class="bg-white p-8 rounded-2xl border border-zinc-200/60 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-purple-50 rounded-xl text-purple-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l8.904-4.43a9.002 9.002 0 0 0 1.132-15.613A9.002 9.002 0 0 0 1.132 12.004a9.002 9.002 0 0 0 8.681 3.9M12 9h.008v.008H12V9Zm0 3h.008v.008H12V12Zm0 3h.008v.008H12V15Z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900 mb-2">Prediksi Kebutuhan Dana AI</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed">Algoritma cerdas yang memudahkan *refinery stakeholder* memprediksi neraca pengeluaran kas berdasarkan tren pasokan pengiriman terkumpul harian.</p>
                        </div>
                        <div class="mt-6 text-xs font-bold text-purple-600 uppercase tracking-wider">Analisis Prediktif Cerdas</div>
                    </div>

                    <!-- Feature 4: Transparansi Neraca -->
                    <div class="bg-white p-8 rounded-2xl border border-zinc-200/60 shadow-sm md:col-span-2 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-amber-50 rounded-xl text-amber-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900 mb-2">Skema Konversi Transparan</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed">Menjamin perhitungan volume kotor (*gross*) dikurangi kadar ampas filtrasi untuk menghasilkan volume bersih (*netto*). Uang dibayarkan adil tanpa manipulasi timbangan.</p>
                        </div>
                        <div class="mt-6 text-xs font-bold text-amber-600 uppercase tracking-wider">Keamanan Data Finansial</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALUR RANTAI PASOK (RBAC BASED) -->
        <section id="alur" class="py-24 bg-white border-t border-zinc-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-zinc-900 tracking-tight sm:text-4xl mb-4">
                        Arsitektur Alur 3 Pilar Utama
                    </h2>
                    <p class="text-zinc-600 font-medium">
                        Platform dirancang menggunakan pembagian hak akses (*Role-Based Access Control*) demi mengunci integritas transaksi.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Pilar 1 -->
                    <div class="bg-zinc-50 border border-zinc-200/50 rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center mb-6 font-extrabold text-base shadow-md shadow-emerald-100">01</div>
                            <h3 class="text-lg font-bold text-zinc-900 mb-3">Masyarakat / Penyetor</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed mb-6">
                                Rumah tangga, UMKM, atau pelaku bisnis kuliner dapat mendaftarkan posisi titik peta, memilih mitra pengepul terdekat dengan penawaran harga terbaik, dan memantau estimasi dana pencairan tabungan minyak secara real-time.
                            </p>
                        </div>
                        <div class="border-t border-zinc-200 pt-4 text-xs font-bold text-emerald-600 uppercase tracking-wider">
                            Akses: Peta Lokasi & Pengajuan Setoran
                        </div>
                    </div>

                    <!-- Pilar 2 -->
                    <div class="bg-zinc-50 border border-zinc-200/50 rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-zinc-900 text-white flex items-center justify-center mb-6 font-extrabold text-base shadow-md shadow-zinc-200">02</div>
                            <h3 class="text-lg font-bold text-zinc-900 mb-3">Jaringan Pengepul</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed mb-6">
                                Bertindak sebagai filter utama pos penampungan kotor. Pengepul mengelola penyesuaian harga beli mandiri (mengacu batasan harga dasar pusat), memverifikasi volume fisik setoran warga, lalu mengirim pasokan masal terkumpul ke kilang pusat.
                            </p>
                        </div>
                        <div class="border-t border-zinc-200 pt-4 text-xs font-bold text-zinc-800 uppercase tracking-wider">
                            Akses: Manajemen Harga Beli & Verifikasi Massa
                        </div>
                    </div>

                    <!-- Pilar 3 -->
                    <div class="bg-zinc-50 border border-zinc-200/50 rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center mb-6 font-extrabold text-base">03</div>
                            <h3 class="text-lg font-bold text-zinc-900 mb-3">Refinery Stakeholder (HEN)</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed mb-6">
                                Pengawas korporasi pusat. Mengontrol rilis standarisasi harga acuan, menginput data Laboratorium Mutu (Uji FFA & kadar air), serta memantau visualisasi grafik sebaran komoditas nasional untuk kebutuhan suplai avtur *Sustainable Aviation Fuel*.
                            </p>
                        </div>
                        <div class="border-t border-zinc-200 pt-4 text-xs font-bold text-emerald-700 uppercase tracking-wider">
                            Akses: QC Lab Control, Dashboard Peta & AI
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INTERACTIVE CALCULATOR SECTION -->
        <section id="kalkulator" class="py-24 bg-zinc-50 border-t border-zinc-100" x-data="{ liters: 10, role: 'masyarakat' }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl border border-zinc-200 p-8 sm:p-12 shadow-sm">
                    <div class="text-center max-w-xl mx-auto mb-10">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 mb-2">Simulasi Konversi & Pendapatan</h2>
                        <p class="text-sm text-zinc-500">Kalkulasikan potensi nilai ekonomi minyak jelantah Anda berdasarkan estimasi rata-rata harga pasar saat ini.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400 mb-2">Saya Mendaftar Sebagai</label>
                                <div class="grid grid-cols-2 gap-2 p-1 bg-zinc-100 rounded-xl">
                                    <button @click="role = 'masyarakat'" :class="role === 'masyarakat' ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-800'" class="py-2 text-xs font-bold rounded-lg transition-all">Masyarakat</button>
                                    <button @click="role = 'pengepul'" :class="role === 'pengepul' ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-800'" class="py-2 text-xs font-bold rounded-lg transition-all">Pengepul</button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400 mb-2">Estimasi Volume Minyak (Liter)</label>
                                <div class="relative">
                                    <input type="number" x-model="liters" class="w-full px-4 py-3 bg-zinc-50 border border-zinc-200 rounded-xl focus:outline-none focus:border-emerald-500 text-zinc-800 font-bold">
                                    <span class="absolute right-4 top-3.5 text-xs font-bold text-zinc-400">Liters</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-emerald-600 rounded-2xl text-white shadow-xl shadow-emerald-600/10 space-y-6">
                            <div>
                                <div class="text-xs font-bold text-emerald-200 uppercase tracking-wider mb-1">Estimasi Pendapatan Anda</div>
                                <div class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                                    <span>Rp</span>
                                    <span x-text="new Intl.NumberFormat('id-ID').format(liters * (role === 'masyarakat' ? 8000 : 11000))"></span>
                                </div>
                            </div>

                            <div class="border-t border-emerald-500/50 pt-4 space-y-2 text-xs">
                                <div class="flex justify-between text-emerald-100">
                                    <span>Asumsi Harga per Liter:</span>
                                    <span class="font-bold" x-text="role === 'masyarakat' ? 'Rp 8.000' : 'Rp 11.000'"></span>
                                </div>
                                <div class="flex justify-between text-emerald-100">
                                    <span>Dampak Lingkungan:</span>
                                    <span class="font-bold" x-text="(liters * 2.5).toFixed(1) + ' Kg Emisi CO2 Dicegah'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ SECTION (ACCORDION) -->
        <section id="faq" class="py-24 bg-white border-t border-zinc-100" x-data="{ activeFaq: null }">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-zinc-900 tracking-tight mb-4">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-zinc-600 font-medium">Informasi mendasar seputar tata cara penukaran komoditas energi JetOil.</p>
                </div>

                <div class="space-y-3">
                    <!-- FAQ 1 -->
                    <div class="border border-zinc-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full flex items-center justify-between p-5 text-left bg-zinc-50 hover:bg-zinc-100/50 transition-colors font-bold text-sm text-zinc-800">
                            <span>Bagaimana sistem JetOil mengukur akurasi timbangan?</span>
                            <svg class="w-4 h-4 transition-transform text-zinc-400" :class="activeFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 1" x-cloak class="p-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 bg-white">
                            Pengepul memvalidasi volume kotor (*gross*) di depan penyetor, lalu setelah dilakukan filtrasi penyaringan endapan air dan kotoran, berat bersih (*netto*) dimasukkan ke dalam sistem secara transparan agar tidak terjadi kecurangan manipulasi tonase.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="border border-zinc-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full flex items-center justify-between p-5 text-left bg-zinc-50 hover:bg-zinc-100/50 transition-colors font-bold text-sm text-zinc-800">
                            <span>Apa itu parameter Laboratorium Mutu di sisi PT HEN?</span>
                            <svg class="w-4 h-4 transition-transform text-zinc-400" :class="activeFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 2" x-cloak class="p-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 bg-white">
                            Untuk memproses minyak jelantah menjadi bio-avtur (*Sustainable Aviation Fuel*), pihak kilang PT HEN menguji kelayakan minyak melalui modul CRUD laboratorium, meliputi batas toleransi FFA (*Free Fatty Acid*), persentase kelembaban air, serta endapan padat.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="border border-zinc-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full flex items-center justify-between p-5 text-left bg-zinc-50 hover:bg-zinc-100/50 transition-colors font-bold text-sm text-zinc-800">
                            <span>Bagaimana cara kerja penentuan pengepul terdekat?</span>
                            <svg class="w-4 h-4 transition-transform text-zinc-400" :class="activeFaq === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 3" x-cloak class="p-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 bg-white">
                            Sistem menggunakan kalkulasi matriks *Haversine Formula*. Ketika masyarakat mengizinkan pelacakan GPS, sistem otomatis menarik radius jarak terpendek ke lokasi depo gudang pengepul teraktif di area sekitar Anda.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="py-20 bg-zinc-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-emerald-950/40 via-transparent to-transparent"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Siap Mengubah Limbah Menjadi Nilai Berharga?</h2>
                <p class="text-sm sm:text-base text-zinc-400 max-w-xl mx-auto mb-8">Bergabunglah ke dalam rantai pasok energi bersih aviasi bersama ratusan penyetor dan kilang nasional terverifikasi.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-zinc-900 bg-white hover:bg-zinc-100 rounded-xl transition-all active:scale-95 shadow-lg">
                    Daftar Akun Sekarang
                </a>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-zinc-950 border-t border-zinc-900 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-[11px] text-zinc-500 tracking-wide">
                    &copy; 2026 PT Hijau Energi Nusantara (HEN). Dikembangkan untuk Pelaksanaan Kompetisi PLAY IT 2026. All rights reserved.
                </p>
            </div>
        </footer>

    </body>
</html>