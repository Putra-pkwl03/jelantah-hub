<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-lg text-slate-800 leading-tight">
                Pusat Kendali Logistik Hub Pengepul
            </h2>
            <span class="text-xs font-medium text-slate-500 mt-1 block">
                Kelola validasi setoran masyarakat, atur harga beli, dan pantau pengiriman ke HEN Refinery.
            </span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8 p-6 bg-gradient-to-r from-indigo-600 to-blue-700 rounded-3xl text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
        <div class="absolute right-0 top-0 translate-x-4 -translate-y-4 opacity-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 8h-3V4H3v12h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2V8h-3zM6 16.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5 0.67 1.5 1.5-.67 1.5-1.5 1.5zm12 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5 0.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
            </svg>
        </div>
        <div class="relative z-10 max-w-xl">
            <h1 class="text-2xl font-bold mb-1">Selamat Bertugas, {{ Auth::user()->name }}! 🚚</h1>
            <p class="text-indigo-100 text-sm leading-relaxed">
                Panel ini memuat seluruh data pasokan minyak jalantah yang masuk dari masyarakat. Pastikan volume timbangan akurat sebelum melakukan verifikasi pencairan dana.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="p-3.5 rounded-xl bg-indigo-50 text-indigo-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok Tangki</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    {{ number_format($totalStok, 1, ',', '.') }} <span class="text-sm font-medium text-slate-500">Liter</span>
                </h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Antrean Aktif</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    {{ $jumlahAntrean }} <span class="text-sm font-medium text-slate-500">Transaksi</span>
                </h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 sm:col-span-2 lg:col-span-1">
            <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5M3.75 20.25zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kas Dana Cair</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">
                    <span class="text-sm font-semibold text-slate-500">Rp</span> {{ number_format($totalKasCair, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="mb-8 bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-900">Peta Sebaran Lokasi Penjemputan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Memantau seluruh sebaran titik lokasi warga yang masuk dalam antrean.</p>
        </div>
        <div id="mainMapContainer" class="w-full h-96 bg-slate-100"></div>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm" 
         x-data="{ 
            openSelesaiModal: false, 
            actionUrl: '', 
            estimasi: 0,
            
            // State untuk Map Modal Fokus Individu
            openMapModal: false,
            mapName: '',
            mapLat: 0,
            mapLng: 0,
            leafletMap: null,
            marker: null,

            initMap(lat, lng, name) {
                this.mapName = name;
                this.mapLat = lat;
                this.mapLng = lng;
                this.openMapModal = true;

                $nextTick(() => {
                    if (!this.leafletMap) {
                        this.leafletMap = L.map('mapModalContainer').setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(this.leafletMap);
                        this.marker = L.marker([lat, lng]).addTo(this.leafletMap);
                    } else {
                        this.leafletMap.setView([lat, lng], 15);
                        this.marker.setLatLng([lat, lng]);
                    }
                    setTimeout(() => { this.leafletMap.invalidateSize() }, 200);
                });
            }
         }">
         
        <div class="p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Antrean Verifikasi & Setoran Masuk</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar berkas pengajuan minyak dari warga yang harus dikonfirmasi.</p>
            </div>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3 px-6">Nama Penyetor</th>
                        <th class="py-3 px-6">Tanggal Masuk</th>
                        <th class="py-3 px-6 text-right">Volume (Est / Bersih)</th>
                        <th class="py-3 px-6 text-right">Nilai Tukar</th>
                        <th class="py-3 px-6 text-center">Status Berkas</th>
                        <th class="py-3 px-6 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    
                    @forelse($setoranMasuk as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-900">{{ $item->masyarakat->name ?? 'Warga Anonim' }}</span>
                                <span class="text-xs text-slate-400">{{ $item->alamat_penjemputan ?? 'Lokasi tidak tertera' }}</span>
                                
                                @if($item->masyarakat && $item->masyarakat->latitude && $item->masyarakat->longitude)
                                    <button type="button" 
                                            @click="initMap({{ $item->masyarakat->latitude }}, {{ $item->masyarakat->longitude }}, '{{ $item->masyarakat->name }}')" 
                                            class="text-left text-xs font-semibold text-indigo-600 hover:text-indigo-800 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        Lihat Posisi Rumah Peta
                                    </button>
                                @else
                                    <span class="text-[11px] text-amber-500 italic mt-1">Koordinat belum diset warga</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($item->status === 'selesai')
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-900">{{ number_format($item->liter_bersih, 1) }} L Bersih</span>
                                    <span class="text-xs text-slate-400">Endapan: {{ number_format($item->endapan, 1) }} L</span>
                                </div>
                            @else
                                <span class="font-semibold text-slate-600">{{ number_format($item->liter_estimasi, 1) }} L (Est)</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-slate-800">
                            @if($item->status === 'selesai')
                                Rp {{ number_format($item->harga_dibayar, 0, ',', '.') }}
                            @else
                                <span class="text-xs text-slate-400 font-normal italic">Menunggu Hitung</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($item->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    Perlu Dijemput
                                </span>
                            @elseif($item->status === 'dijemput')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    Proses Angkut
                                </span>
                            @elseif($item->status === 'selesai')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Selesai / Masuk Tangki
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($item->status === 'pending')
                                    <form method="POST" action="{{ route('pengepul.setoran.simpan-uji', $item->id) }}" class="inline m-0">
                                        @csrf
                                        <input type="hidden" name="action" value="jemput">
                                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                                            Ambil Setoran
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('pengepul.setoran.simpan-uji', $item->id) }}" class="inline m-0">
                                        @csrf
                                        <input type="hidden" name="action" value="tolak">
                                        <button type="submit" onclick="return confirm('Tolak setoran ini?')" class="px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors">
                                            Tolak
                                        </button>
                                    </form>

                                @elseif($item->status === 'dijemput')
                                    <button type="button" 
                                        @click="openSelesaiModal = true; actionUrl = '{{ route('pengepul.setoran.simpan-uji', $item->id) }}'; estimasi = {{ $item->liter_estimasi }}"
                                        class="px-3 py-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors shadow-sm">
                                        Validasi & Timbang
                                    </button>
                                @else
                                    <span class="text-xs font-medium text-slate-400 italic">Terverifikasi</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 italic">
                            Belum ada antrean masuk untuk akun pengepul Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="openSelesaiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="bg-white p-6 rounded-3xl max-w-sm w-full shadow-2xl border border-slate-100" @click.away="openSelesaiModal = false">
                <h4 class="font-bold text-slate-900 text-base mb-1">Penyaringan & Berat Bersih</h4>
                <p class="text-xs text-slate-500 mb-4">Masukkan total endapan kotoran (liter) hasil penyaringan fisik.</p>
                
                <div class="bg-slate-50 p-3 rounded-xl mb-4 text-xs text-slate-600">
                    Estimasi Awal Warga: <strong x-text="estimasi + ' Liter'"></strong>
                </div>

                <form :action="actionUrl" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="selesai">
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Jumlah Endapan (Liter)</label>
                        <input type="number" step="0.1" name="endapan" required min="0" placeholder="Contoh: 1.5"
                            class="w-full text-sm border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3 py-2">
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button type="button" @click="openSelesaiModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-all shadow-sm">
                            Simpan & Selesai
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="openMapModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden" @click.away="openMapModal = false">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-base">Lokasi Penjemputan</h4>
                        <p class="text-xs text-slate-500">Milik Warga: <span class="font-semibold text-slate-700" x-text="mapName"></span></p>
                    </div>
                    <button @click="openMapModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div id="mapModalContainer" class="w-full h-80 bg-slate-100"></div>

                <div class="p-4 bg-slate-50 flex justify-between items-center gap-2">
                    <span class="text-[11px] text-slate-400 italic">Klik tombol kanan untuk rute navigasi langsung.</span>
                    <div class="flex gap-2">
                        <button type="button" @click="openMapModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition-all">
                            Tutup
                        </button>
                        <a :href="'https://www.google.com/maps/search/?api=1&query=' + mapLat + ',' + mapLng" 
                           target="_blank" 
                           class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-sm inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 11.518 1.4L11.25 13v1.5a.75.75 0 01-1.5 0v-2.25A.75.75 0 0110.5 11.5h.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 10-1.5 0 .75.75 0 001.5 0z" />
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sediakan array penampung data koordinat dari Laravel
            const locations = [
                @foreach($setoranMasuk as $item)
                    @if($item->masyarakat && $item->masyarakat->latitude && $item->masyarakat->longitude)
                    {
                        lat: {{ $item->masyarakat->latitude }},
                        lng: {{ $item->masyarakat->longitude }},
                        name: "{{ $item->masyarakat->name }}",
                        status: "{{ $item->status }}",
                        volume: "{{ $item->status === 'selesai' ? $item->liter_bersih . ' L (Bersih)' : $item->liter_estimasi . ' L (Est)' }}"
                    },
                    @endif
                @endforeach
            ];

            // Setup default view (Default Surabaya, silakan sesuaikan)
            let defaultLat = -7.2504; 
            let defaultLng = 112.7508;
            let defaultZoom = 12;

            if (locations.length > 0) {
                defaultLat = locations[0].lat;
                defaultLng = locations[0].lng;
            }

            const mainMap = L.map('mainMapContainer').setView([defaultLat, defaultLng], defaultZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mainMap);

            // Tambahkan marker titik jemput ke peta utama secara otomatis
            locations.forEach(loc => {
                const markerColor = loc.status === 'selesai' ? 'green' : (loc.status === 'dijemput' ? 'blue' : 'orange');
                const popupContent = `
                    <div class="p-1">
                        <h5 class="font-bold text-sm text-slate-900">${loc.name}</h5>
                        <p class="text-xs text-slate-500 mt-0.5">Volume: ${loc.volume}</p>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-semibold mt-1 rounded bg-slate-100 text-slate-700 uppercase">${loc.status}</span>
                    </div>
                `;
                
                L.marker([loc.lat, loc.lng])
                    .addTo(mainMap)
                    .bindPopup(popupContent);
            });
        });
    </script>
</x-app-layout>