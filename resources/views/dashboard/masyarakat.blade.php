<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
 <x-slot name="header">
        <div>
            <h2 class="font-bold text-lg text-slate-800 leading-tight">
                 Ringkasan Aktivitas Warga
            </h2>
            <span class="text-xs font-medium text-slate-500 mt-1 block">
                Setiap liter minyak jelantah yang Anda setorkan membantu mengurangi emisi karbon bumi.
            </span>
        </div>
    </x-slot>
    <div class="mb-8 p-6 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl text-white shadow-xl shadow-emerald-100 relative overflow-hidden">
        <div class="absolute right-0 top-0 translate-x-4 -translate-y-4 opacity-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
            </svg>
        </div>
        <div class="relative max-w-xl">
            <h1 class="text-2xl font-bold mb-1">Halo, {{ Auth::user()->name }}! 🌱</h1>
            <p class="text-emerald-100 text-sm leading-relaxed">
                Terima kasih telah berkontribusi menjaga kelestarian bumi. Setiap liter minyak jelantah yang Anda setorkan membantu mengurangi emisi karbon bumi.
            </p>
            <div class="mt-4">
                <a href="{{ route('masyarakat.setoran.create') }}" class="inline-flex items-center gap-2 bg-white text-emerald-700 px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-emerald-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Buat Pengajuan Setoran Baru
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Kontribusi</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    {{ number_format($totalMinyakSelesai, 1, ',', '.') }} <span class="text-sm font-medium text-slate-500">Liter</span>
                </h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5M3.75 20.25zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Eco Points Anda</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    {{ number_format($totalPoin, 0, ',', '.') }} <span class="text-sm font-medium text-amber-600">Pts</span>
                </h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 sm:col-span-2 lg:col-span-1">
            <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Transaksi</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    {{ $totalPengajuan }} <span class="text-sm font-medium text-slate-500">Berkas</span>
                </h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-1 bg-white border border-slate-200 rounded-3xl p-5 shadow-sm flex flex-col">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">Radar Hub Pengepul</h3>
                <p class="text-xs text-slate-500 mt-0.5">Titik agen pengepul terdekat di sekitar koordinat Anda.</p>
            </div>
            
            <div id="mapDashboard" class="w-full h-64 rounded-2xl border border-slate-100 z-0 flex-1 min-h-[260px]"></div>
            
            <div class="mt-3">
                <a href="{{ action([App\Http\Controllers\Masyarakat\PengepulController::class, 'index']) }}" class="w-full inline-flex justify-center items-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors">
                    Lihat Semua Detail Mitra Pengepul
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Aktivitas Setoran Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pantau berkas status pengajuan real-time Anda.</p>
                </div>
                <a href="{{ route('masyarakat.riwayat') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Pengepul Tujuan</th>
                            <th class="pb-3">Estimasi Volume</th>
                            <th class="pb-3">Waktu Penjemputan</th>
                            <th class="pb-3 pr-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                        @forelse($riwayatTerbaru as $row)
                            <tr>
                                <td class="py-3.5 pl-2">
                                    <div class="font-bold text-slate-800">{{ $row->pengepul->name ?? 'Minyak Hub' }}</div>
                                    <div class="text-xs text-slate-400">ID-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="py-3.5 font-medium">
                                    {{ $row->liter_estimasi }} Liter
                                </td>
                                <td class="py-3.5 text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_penjemputan)->translatedFormat('d M Y') }} <br>
                                    <span class="text-slate-400">Pukul {{ substr($row->jam_penjemputan, 0, 5) }} WIB</span>
                                </td>
                                <td class="py-3.5 pr-2 text-right">
                                    @if($row->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>
                                    @elseif($row->status === 'dijemput')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">Dijemput</span>
                                    @elseif($row->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200">Batal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400 text-xs">
                                    Belum ada catatan transaksi setoran minyak jelantah saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Ambil titik koordinat pusat (Rumah Masyarakat)
            var userLat = {{ $lat }};
            var userLng = {{ $lon }};
            
            // Initialize Peta
            var map = L.map('mapDashboard').setView([userLat, userLng], 13);
            
            // Set Layer Desain Peta OpenStreetMap (Clean Style)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 2. Tandai Pin Merah/Biru untuk Lokasi User Sendiri
            var userIcon = L.divIcon({
                html: `<div class="w-4 h-4 bg-blue-600 border-2 border-white rounded-full shadow-md animate-ping absolute"></div><div class="w-4 h-4 bg-blue-600 border-2 border-white rounded-full shadow-md relative"></div>`,
                className: 'custom-pin-user',
                iconSize: [16, 16]
            });
            L.marker([userLat, userLng], {icon: userIcon}).addTo(map)
                .bindPopup("<b>Lokasi Rumah Anda</b>").openPopup();

            // 3. Looping data array Pengepul Terdekat dari Controller ke Map Javascript
            @foreach($pengepulTerdekat as $item)
                @if($item->latitude && $item->longitude)
                    L.marker([{{ $item->latitude }}, {{ $item->longitude }}])
                        .addTo(map)
                        .bindPopup(`
                            <div class="text-xs p-1">
                                <b class="text-slate-800 text-sm block">${"{{ $item->name }}"}</b>
                                <span class="text-emerald-600 font-bold block mt-1">Rp ${numberWithCommas({{ $item->harga_per_liter ?? 0 }})}/Ltr</span>
                                <span class="text-slate-400 block mt-0.5">⏱ Jarak: ${ {{ $item->jarak ?? 0 }} } km</span>
                            </div>
                        `);
                @endif
            @endforeach

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
</x-app-layout>