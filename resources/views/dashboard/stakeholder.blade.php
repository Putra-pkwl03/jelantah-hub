<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4 pb-2 border-b border-slate-100">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight tracking-tight flex items-center gap-3">
                    Dashboard Executive
                </h2>
                <p class="text-xs text-slate-400 mt-1 ml-1 font-medium tracking-wide">PT HEN Hub Management System</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50/60 backdrop-blur border border-emerald-200 text-emerald-900 rounded-2xl flex items-start gap-3 text-sm font-medium shadow-sm transition-all animate-fade-in">
        <span class="p-1 bg-emerald-100 text-emerald-700 rounded-lg shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <div>
            <span class="font-bold text-emerald-900 block">Berhasil!</span>
            <span class="text-xs text-emerald-700/90 font-normal mt-0.5 block">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Volume Bersih SAF</span>
                <span class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.656 48.656 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3M3 12a9 9 0 1118 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-6">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalMinyakSelesai, 1) }} <span class="text-sm font-bold text-slate-400">L</span></h3>
                <p class="text-[11px] text-slate-400 mt-1 font-medium">Terakumulasi dari total pasokan lolos lab</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Butuh Uji Lab</span>
                <span class="p-2.5 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </span>
            </div>
            <div class="mt-6">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $antreanKendaliMutu }} <span class="text-sm font-bold text-slate-400">Batch</span></h3>
                <p class="text-[11px] text-amber-600 font-semibold mt-1 inline-flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Antrean Verifikasi Aktif
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Total Dana Cair</span>
                <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.214.122a6.409 6.409 0 002.507.642c.16 0 .321-.004.478-.013A6.431 6.431 0 0015 14.978c0-2.434-2.197-2.308-4.22-2.544C8.75 12.182 6.75 12.03 6.75 10.02c0-1.819 1.636-2.923 3.75-3.13V4.5m4.22 13.82V18.75m3.75-14.25v14.25" />
                    </svg>
                </span>
            </div>
            <div class="mt-6">
                <h3 class="text-xl font-black text-slate-800 tracking-tight leading-none">Rp {{ number_format($totalPengeluaranInsentif, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-slate-400 mt-2 font-medium">Insentif komersial yang telah dicairkan</p>
            </div>
        </div>

        <div class="bg-slate-900 p-6 rounded-3xl text-white shadow-xl flex flex-col justify-between border border-slate-800 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent pointer-events-none"></div>
            <div class="flex items-center justify-between relative">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-indigo-300 uppercase tracking-widest">Prediksi Dana AI</span>
                    <span class="bg-indigo-500 text-[8px] font-black px-1.5 py-0.5 rounded text-white tracking-widest">ML</span>
                </div>
                <span class="p-2.5 bg-white/10 text-indigo-300 rounded-xl border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l8.954-8.955M21 12h0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-6 relative z-10">
                <h3 class="text-xl font-black text-white tracking-tight">Rp {{ number_format($prediksiDanaBulanDepan, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400 mt-2 italic font-normal">*Periode Depan (Regresi Linier)</p>
            </div>
        </div>
    </div>

    <x-stakeholder-map-hub 
        :titikRekomendasiHub="$titikRekomendasiHub" 
        :titikPetaPengepul="$titikPetaPengepul" 
        :titikPetaMasyarakat="$titikPetaMasyarakat" 
    />

    <div id="tabel-kendali-mutu" class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm mt-8">
        <div class="p-6 border-b border-slate-50">
            <h3 class="text-base font-bold text-slate-900 tracking-tight">Arus Verifikasi Batch & Kelayakan Mutu</h3>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Validasi kualitas parameter uji laboratorium terhadap kriteria konversi energi Avtur / SAF.</p>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 text-slate-400 text-[10px] font-bold uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6">Pelaku Rantai Pasok</th>
                        <th class="py-4 px-6">Tanggal Ambil</th>
                        <th class="py-4 px-6 text-right">Volume / Nominal</th>
                        <th class="py-4 px-6 text-center">Hasil Analisis Laboratorium (H2O | FFA | Imp)</th>
                        <th class="py-4 px-6 text-center">Status Kelayakan</th>
                        <th class="py-4 px-6 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm text-slate-700 font-medium">
                    @forelse($semuaSetoran as $row)
                    <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 text-sm tracking-tight">{{ $row->pengepul->name ?? 'Pengepul Lapangan' }}</span>
                                <span class="text-xs text-slate-400 font-normal mt-0.5">Asal Warga: {{ $row->masyarakat->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-500 text-xs font-normal">
                            {{ $row->tanggal_penjemputan ? $row->tanggal_penjemputan->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="font-extrabold text-slate-900">{{ number_format($row->liter_bersih ?? $row->liter_estimasi, 1) }} L</div>
                            <div class="text-[11px] text-slate-400 font-normal mt-0.5">Rp {{ number_format($row->harga_dibayar, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if(is_null($row->kadar_air))
                                <span class="text-[11px] text-slate-400 bg-slate-100 px-2.5 py-1 rounded-md font-normal italic">Menunggu Sampel</span>
                            @else
                                <div class="inline-flex gap-1 text-[11px] font-mono tracking-tight">
                                    <span class="bg-blue-50/60 text-blue-700 px-2 py-0.5 rounded border border-blue-100/60 font-semibold">H2O: {{ $row->kadar_air }}%</span>
                                    <span class="bg-purple-50/60 text-purple-700 px-2 py-0.5 rounded border border-purple-100/60 font-semibold">FFA: {{ $row->ffa }}%</span>
                                    <span class="bg-amber-50/60 text-amber-700 px-2 py-0.5 rounded border border-amber-100/60 font-semibold">Imp: {{ $row->kotoran }}%</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($row->status === 'proses')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Butuh Uji Lab
                                </span>
                            @elseif($row->status === 'selesai')
                                <div class="flex flex-col items-center">
                                    <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">Lolos Analisis</span>
                                    <span class="text-[10px] text-slate-400 font-bold mt-1 tracking-wider uppercase">{{ $row->grade }}</span>
                                </div>
                            @elseif($row->status === 'ditolak')
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-100">Reject / Tolak</span>
                            @else
                                <span class="px-2.5 py-1 text-[11px] font-medium rounded-full bg-slate-50 text-slate-500 border border-slate-100">Pending</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($row->status === 'proses')
                                <a href="{{ route('stakeholder.lab.edit', $row->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-sm tracking-wide uppercase">
                                    Input Lab
                                </a>
                            @else
                                <span class="text-xs text-slate-300 font-normal italic">Verified</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-xs text-slate-400 font-normal italic bg-slate-50/30">Belum ada rekaman sirkular pasokan minyak yang terdaftar di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>