@props(['titikRekomendasiHub', 'titikPetaPengepul', 'titikPetaMasyarakat'])

<div>
    @if($titikRekomendasiHub)
    <div class="bg-gradient-to-r from-rose-50 to-amber-50 p-6 rounded-3xl border border-rose-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-start gap-4">
            <span class="p-3 bg-rose-600 text-white rounded-2xl shadow-lg shadow-rose-200 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
            </span>
            <div>
                <span class="bg-rose-100 text-rose-700 text-[9px] font-black tracking-widest uppercase px-2 py-0.5 rounded-full inline-block mb-1">Rekomendasi Ekspansi AI</span>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Titik Tengah Centroid Strategis Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">Mencakup <span class="text-rose-600 font-bold">{{ $titikRekomendasiHub['total_penyetor_sekitar'] }} penyetor</span> aktif di sekitarnya berdasarkan analisis klastering.</p>
            </div>
        </div>
        <button type="button" 
                onclick="bukaModalHubDenganKoordinat('{{ $titikRekomendasiHub['latitude'] }}', '{{ $titikRekomendasiHub['longitude'] }}')" 
                class="w-full sm:w-auto px-5 py-2.5 bg-rose-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-rose-100 hover:bg-rose-700 hover:shadow-none transition-all duration-200 tracking-wide uppercase">
            Buka Hub Baru
        </button>
    </div>
    @endif

    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Peta Penyebaran Rantai Pasok Wilayah</h3>
                <p class="text-xs text-slate-400 mt-0.5 font-medium">Visualisasi real-time jaringan logistik Hub Pengepul dan sebaran Penyetor Aktif.</p>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-semibold bg-slate-50 border border-slate-100 px-4 py-2 rounded-2xl flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 ring-4 ring-indigo-100"></span>
                    <span class="text-slate-600">Hub Pengepul</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 ring-4 ring-amber-100"></span>
                    <span class="text-slate-600">Masyarakat/Penyetor</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600 ring-4 ring-rose-100 animate-pulse"></span>
                    <span class="text-rose-700 font-bold">Rekomendasi AI</span>
                </div>
            </div>
        </div>
        <div class="p-4 bg-slate-50/50">
            <div id="petaSirkularMinyak" class="w-full rounded-2xl border border-slate-200/60 shadow-inner bg-slate-100 overflow-hidden" style="height: 440px; z-index: 1;"></div>
        </div>
    </div>

    <div id="modalHub" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white rounded-3xl p-6 w-[400px] shadow-2xl border border-slate-100 transform transition-transform scale-100 animate-scale-in">
            <div class="flex items-center justify-between pb-4 border-b border-slate-50 mb-4">
                <h3 class="font-black text-slate-900 text-lg tracking-tight">Tetapkan Hub Aktif Baru</h3>
                <button type="button" onclick="tutupModalHub()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('stakeholder.hub.store') }}" method="POST">
                @csrf
                <input type="hidden" name="latitude" id="modal_latitude">
                <input type="hidden" name="longitude" id="modal_longitude">
                
                <div class="mb-4 bg-slate-50 p-3 rounded-xl border border-slate-200/60 text-xs font-mono text-slate-500">
                    <div class="flex justify-between">
                        <span>LATITUDE:</span>
                        <span id="label_lat" class="font-bold text-slate-800">-</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>LONGITUDE:</span>
                        <span id="label_lng" class="font-bold text-slate-800">-</span>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Hub Penerimaan</label>
                    <input type="text" name="nama_hub" placeholder="Contoh: Hub Sektor Solo Selatan" class="w-full rounded-xl border-slate-200 text-sm font-medium focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 placeholder-slate-300" required>
                </div>
                
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="tutupModalHub()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:shadow-none transition-all">Simpan Lokasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi Utama penangkap data koordinat otomatis
    function bukaModalHubDenganKoordinat(lat, lng) {
        document.getElementById('modal_latitude').value = lat;
        document.getElementById('modal_longitude').value = lng;
        document.getElementById('label_lat').innerText = parseFloat(lat).toFixed(6);
        document.getElementById('label_lng').innerText = parseFloat(lng).toFixed(6);
        
        document.getElementById('modalHub').classList.remove('hidden');
    }

    function tutupModalHub() { 
        document.getElementById('modalHub').classList.add('hidden'); 
    }

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
                iconSize: [24, 24],
                iconAnchor: [12, 12],
                popupAnchor: [0, -10]
            });
        }

        var penandaPengepul      = createCustomMarker('bg-indigo-600');
        var penandaPenyetor      = createCustomMarker('bg-amber-500');
        var penandaRekomendasiAI = createCustomMarker('bg-rose-600');

        var seluruhTitikKoor = [];

        // 1. Plot Pengepul
        var dataPengepul = @json($titikPetaPengepul ?? []);
        dataPengepul.forEach(function (hub) {
            if(hub.latitude && hub.longitude) {
                var lat = parseFloat(hub.latitude);
                var lng = parseFloat(hub.longitude);
                seluruhTitikKoor.push([lat, lng]);

                L.marker([lat, lng], {icon: penandaPengepul})
                 .addTo(mapSirkular)
                 .bindPopup("<div class='font-sans'><b class='text-slate-900 text-sm'>" + hub.name + "</b><br><span class='text-[10px] text-indigo-600 font-bold uppercase'>📍 HUB PENGEPUL AGEN</span></div>");
            }
        });

        // 2. Plot Masyarakat
        var dataMasyarakat = @json($titikPetaMasyarakat ?? []);
        dataMasyarakat.forEach(function (warga) {
            if(warga.latitude && warga.longitude) {
                var lat = parseFloat(warga.latitude);
                var lng = parseFloat(warga.longitude);
                seluruhTitikKoor.push([lat, lng]);

                L.marker([lat, lng], {icon: penandaPenyetor})
                 .addTo(mapSirkular)
                 .bindPopup("<div class='font-sans'><b class='text-slate-900 text-sm'>" + warga.name + "</b><br><span class='text-[10px] text-amber-600 font-bold uppercase'>🏠 PENYETOR / WARGA</span></div>");
            }
        });

        // 3. Plot Rekomendasi AI + Interaksi Klik Langsung Jadi Hub Baru
        var rekomendasiAI = @json($titikRekomendasiHub ?? null);
        if(rekomendasiAI && rekomendasiAI.latitude && rekomendasiAI.longitude) {
            var latAI = parseFloat(rekomendasiAI.latitude);
            var lngAI = parseFloat(rekomendasiAI.longitude);
            seluruhTitikKoor.push([latAI, lngAI]);

            // Menyusun isi popup html dengan menambahkan trigger tombol eksekusi JS
            var popupContent = `
                <div class='font-sans text-center min-w-[190px] p-1'>
                    <span class='bg-rose-100 text-rose-700 px-2 py-0.5 rounded text-[10px] font-black tracking-wider uppercase inline-block mb-1 shadow-xs'>💡 REKOMENDASI EKSPANSI AI</span>
                    <p class='text-xs text-slate-700 font-bold mt-1.5'>Titik Tengah Centroid</p>
                    <p class='text-[11px] text-slate-500 mt-0.5 mb-3'>Mencakup ${rekomendasiAI.total_penyetor_sekitar ?? 0} penyetor aktif sekitar.</p>
                    <button type='button' 
                            onclick='bukaModalHubDenganKoordinat(${latAI}, ${lngAI})' 
                            class='w-full py-1.5 bg-rose-600 text-white text-[10px] font-extrabold rounded-lg hover:bg-rose-700 transition-colors uppercase tracking-wider'>
                        Jadikan Hub Baru
                    </button>
                </div>
            `;

            L.marker([latAI, lngAI], {icon: penandaRekomendasiAI})
             .addTo(mapSirkular)
             .bindPopup(popupContent);
        }

        if(seluruhTitikKoor.length > 0) {
            mapSirkular.fitBounds(seluruhTitikKoor, { padding: [40, 40] });
        }
    });
</script>