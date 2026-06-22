@props(['titikRekomendasiHub', 'titikPetaPengepul', 'titikPetaMasyarakat', 'semuaHub' => []])

<div class="space-y-6">
    

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <div class="lg:col-span-5 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between flex-wrap gap-4 bg-slate-50/40">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Peta Penyebaran Wilayah</h3>
                    <p class="text-xs text-slate-400 mt-0.5 font-medium">Visualisasi cakupan zonasi real-time.</p>
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold bg-white border border-slate-100 p-1.5 rounded-xl shadow-xs">
                    <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-600"></span><span>Hub</span></div>
                    <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span><span>Warga</span></div>
                    <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span><span>AI</span></div>
                </div>
            </div>
            <div class="p-4 bg-slate-50/20 flex-1 flex flex-col">
                <div id="petaSirkularMinyak" class="w-full rounded-2xl border border-slate-200/60 shadow-inner bg-slate-100 overflow-hidden flex-1" style="min-height: 400px; z-index: 1;"></div>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-50 bg-slate-50/40">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Log Jaringan Hub Terdaftar</h3>
                    <p class="text-xs text-slate-400 mt-0.5 font-medium">Daftar otoritas zonasi penampungan aktif PT HEN.</p>
                </div>
                
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 text-slate-400 text-[10px] font-bold uppercase tracking-widest border-b border-slate-100">
                                <th class="py-4 px-6">Nama Hub Penerimaan</th>
                                <th class="py-4 px-6">Garis Koordinat Spasial</th>
                                <th class="py-4 px-6 text-center">Status Jaringan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm text-slate-700 font-medium">
                            @forelse($semuaHub as $hub)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="py-4 px-6 font-bold text-slate-900 tracking-tight">{{ $hub->nama_hub }}</td>
                                <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                    {{ number_format($hub->latitude, 5) }}, {{ number_format($hub->longitude, 5) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">
                                        {{ $hub->status ?? 'Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-xs text-slate-400 font-normal italic bg-slate-50/30">
                                    Belum ada Hub operasional yang dideploy di sistem database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalHub" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white rounded-3xl p-6 w-[420px] shadow-2xl border border-slate-100 transform transition-transform scale-100">
            <div class="flex items-center justify-between pb-3 border-b border-slate-50 mb-3">
                <h3 class="font-black text-slate-900 text-base tracking-tight">Tetapkan Hub Aktif Baru</h3>
                <button type="button" onclick="tutupModalHub()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="mb-3 relative rounded-xl border border-slate-200 overflow-hidden shadow-inner bg-slate-100">
                <div id="petaMiniModal" style="width: 100%; height: 140px; z-index: 10;"></div>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-4">
                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-2.5 text-center">
                    <span class="block text-[10px] font-bold text-indigo-400 uppercase tracking-wider">Pengepul Terdekat</span>
                    <span id="stat_pengepul" class="text-base font-black text-indigo-700">Memindai...</span>
                </div>
                <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-2.5 text-center">
                    <span class="block text-[10px] font-bold text-amber-500 uppercase tracking-wider">Total Pemasok</span>
                    <span id="stat_pemasok" class="text-base font-black text-amber-700">Memindai...</span>
                </div>
            </div>

            <form action="{{ route('stakeholder.hub.store') }}" method="POST">
                @csrf
                <input type="hidden" name="latitude" id="modal_latitude">
                <input type="hidden" name="longitude" id="modal_longitude">

                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Hub Penerimaan</label>
                    <input type="text" name="nama_hub" placeholder="Contoh: Hub Sektor Solo Selatan" class="w-full rounded-xl border-slate-200 text-sm font-medium focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 placeholder-slate-300" required>
                </div>
                
                <div class="flex gap-3 justify-end pt-1">
                    <button type="button" onclick="tutupModalHub()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">Simpan Lokasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var petaMiniInstance = null;
    var markerMiniInstance = null;

    function tutupModalHub() { document.getElementById('modalHub').classList.add('hidden'); }

    document.addEventListener('DOMContentLoaded', function () {
        var mapSirkular = L.map('petaSirkularMinyak').setView([-7.5666, 110.8166], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapSirkular);

        function createCustomMarker(colorClass) {
            return L.divIcon({
                className: 'custom-pin-container',
                html: `<div class="relative w-6 h-6 flex items-center justify-center">
                        <span class="absolute w-5 h-5 rounded-full ${colorClass} opacity-30 animate-ping"></span>
                        <span class="relative w-3 h-3 rounded-full ${colorClass} border-2 border-white shadow-md"></span>
                       </div>`,
                iconSize: [24, 24], iconAnchor: [12, 12], popupAnchor: [0, -10]
            });
        }

        var penandaPengepul      = createCustomMarker('bg-indigo-600');
        var penandaPenyetor      = createCustomMarker('bg-amber-500');
        var penandaRekomendasiAI = createCustomMarker('bg-rose-600');
        var seluruhTitikKoor = [];

        var dataPengepul = @json($titikPetaPengepul ?? []);
        dataPengepul.forEach(function (hub) {
            if(hub.latitude && hub.longitude) {
                var lat = parseFloat(hub.latitude); var lng = parseFloat(hub.longitude);
                seluruhTitikKoor.push([lat, lng]);
                L.marker([lat, lng], {icon: penandaPengepul}).addTo(mapSirkular)
                 .bindPopup("<div class='font-sans'><b class='text-slate-900 text-sm'>" + hub.name + "</b><br><span class='text-[10px] text-indigo-600 font-bold uppercase'>📍 HUB PENGEPUL AGEN</span></div>");
            }
        });

        var dataMasyarakat = @json($titikPetaMasyarakat ?? []);
        dataMasyarakat.forEach(function (warga) {
            if(warga.latitude && warga.longitude) {
                var lat = parseFloat(warga.latitude); var lng = parseFloat(warga.longitude);
                seluruhTitikKoor.push([lat, lng]);
                L.marker([lat, lng], {icon: penandaPenyetor}).addTo(mapSirkular)
                 .bindPopup("<div class='font-sans'><b class='text-slate-900 text-sm'>" + warga.name + "</b><br><span class='text-[10px] text-amber-600 font-bold uppercase'>🏠 PENYETOR / WARGA</span></div>");
            }
        });

        var rekomendasiAI = @json($titikRekomendasiHub ?? null);
        if(rekomendasiAI && rekomendasiAI.latitude && rekomendasiAI.longitude) {
            var latAI = parseFloat(rekomendasiAI.latitude); var lngAI = parseFloat(rekomendasiAI.longitude);
            seluruhTitikKoor.push([latAI, lngAI]);

            var popupContent = `
                <div class='font-sans text-center min-w-[190px] p-1'>
                    <span class='bg-rose-100 text-rose-700 px-2 py-0.5 rounded text-[10px] font-black tracking-wider uppercase inline-block mb-1 shadow-xs'>💡 REKOMENDASI EKSPANSI AI</span>
                    <p class='text-xs text-slate-700 font-bold mt-1.5'>Titik Tengah Centroid</p>
                    <p class='text-[11px] text-slate-500 mt-0.5 mb-3'>Mencakup ${rekomendasiAI.total_penyetor_sekitar ?? 0} penyetor aktif sekitar.</p>
                    <button type='button' 
                            onclick='bukaModalHubDenganKoordinat(${latAI}, ${lngAI})' 
                            class='w-full py-1.5 bg-rose-600 text-white text-[10px] font-extrabold rounded-lg hover:bg-rose-700 transition-colors uppercase tracking-wider shadow-sm'>
                        Jadikan Hub Baru
                    </button>
                </div>
            `;
            L.marker([latAI, lngAI], {icon: penandaRekomendasiAI}).addTo(mapSirkular).bindPopup(popupContent);
        }

        if(seluruhTitikKoor.length > 0) { mapSirkular.fitBounds(seluruhTitikKoor, { padding: [40, 40] }); }
    });
</script>