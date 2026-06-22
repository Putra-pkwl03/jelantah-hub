<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center pb-2 border-b border-slate-100">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Pusat Kendali Makro PT HEN') }}
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-medium tracking-wide">Zonasi Distribusi Aliran Kaskade Jaringan Nasional</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-slate-50" x-data="{ 
        hargaAcuan: {{ $stakeholder->harga_per_liter ?? 11500 }}, 
        subsidi: 1500 
    }">
        <div class="max-w-7xl mx-auto space-y-4">

            @if(session('success'))
            <div class="p-4 bg-emerald-50/70 backdrop-blur border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm flex items-start gap-3 text-sm font-medium animate-fade-in">
                <span class="p-1 bg-emerald-100 text-emerald-700 rounded-lg shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <span class="font-bold text-emerald-900 block">Berhasil Perbarui Data!</span>
                    <span class="text-xs text-emerald-700/90 font-normal mt-0.5 block">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="font-bold text-slate-900 text-base tracking-tight">Update Harga Batas Atas</h3>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium">Menentukan batas kaskade harga ke seluruh sub-pengepul nasional.</p>
                        </div>
                        
                        <form action="{{ route('stakeholder.harga.update') }}" method="POST" class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Harga Standar PT HEN (Per Liter)</label>
                                <div class="relative mt-1 rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-slate-400 font-bold text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="harga_per_liter" id="harga_per_liter" x-model.number="hargaAcuan" class="block w-full rounded-xl border-slate-200 pl-11 pr-4 py-2.5 text-slate-800 font-black focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm">
                                </div>
                                <p class="mt-2 text-[10px] text-slate-400 font-normal italic">*Pengepul disarankan mengambil margin maksimum 15% dari nilai ini.</p>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Subsidi Insentif Avtur/SAF</label>
                                <div class="relative mt-1 rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-slate-400 font-bold text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="subsidi_insentif" id="subsidi_insentif" x-model.number="subsidi" class="block w-full rounded-xl border-slate-200 pl-11 pr-4 py-2.5 text-emerald-700 font-black focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="p-6 bg-slate-50/50 border-t border-slate-50">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-md transition-all uppercase tracking-wider">
                            Terapkan Perubahan Makro
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg tracking-tight mb-0.5">Simulasi Distribusi Aliran Harga (Kaskade)</h3>
                        <p class="text-xs text-slate-400 font-medium mb-6">Mekanisme otomatisasi perlindungan harga pasar jelantah di tingkat masyarakat.</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl shadow-inner">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-black text-sm">1</div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 tracking-tight">Pabrik Utama PT HEN (Batas Atas Keluar)</h4>
                                    <p class="text-xs text-slate-400 font-normal mt-0.5">Harga beli maksimal industri dari pengepul berizin</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-base font-black text-slate-900 block" x-text="'Rp ' + (hargaAcuan + subsidi).toLocaleString('id-ID') + ' /L'"></span>
                                    <p class="text-[10px] text-slate-400 font-bold mt-0.5 uppercase tracking-wide">Incl. Insentif Mutu</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 bg-indigo-50/50 border border-indigo-100/40 rounded-2xl ml-0 sm:ml-6 shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-black text-sm">2</div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-indigo-900 tracking-tight">Rekomendasi Batas Beli Pengepul Hub</h4>
                                    <p class="text-xs text-indigo-500/70 font-normal mt-0.5">Margin operasional logistik depot penampungan</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-base font-black text-indigo-700 block" x-text="'Rp ' + Math.round(hargaAcuan * 0.85).toLocaleString('id-ID') + ' /L'"></span>
                                    <p class="text-[10px] text-indigo-500 font-bold mt-0.5 uppercase tracking-wide">Margin Perlindungan ~15%</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 p-4 bg-emerald-50/50 border border-emerald-100/40 rounded-2xl ml-0 sm:ml-12 shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black text-sm">3</div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-emerald-900 tracking-tight">Harga Minimum Diterima Masyarakat</h4>
                                    <p class="text-xs text-emerald-600/70 font-normal mt-0.5">Lantai dasar jaminan insentif ekonomi sirkular</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-base font-black text-emerald-700 block" x-text="'Rp ' + Math.round(hargaAcuan * 0.74).toLocaleString('id-ID') + ' /L'"></span>
                                    <p class="text-[10px] text-emerald-500 font-bold mt-0.5 uppercase tracking-wide">Lantai Dasar Aman Juri</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-50 text-[11px] text-slate-400 flex items-center space-x-2 font-medium">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Perubahan data makro ini langsung disinkronisasikan ke widget info harga pada dashboard akun Pengepul dan Masyarakat secara realtime.</span>
                    </div>
                </div>
            </div>

            <x-stakeholder-hub-crud 
                :titikRekomendasiHub="$titikRekomendasiHub"
                :titikPetaPengepul="$titikPetaPengepul"
                :titikPetaMasyarakat="$titikPetaMasyarakat"
            />

        </div>
    </div>
</x-app-layout>