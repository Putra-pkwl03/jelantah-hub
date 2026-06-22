<x-app-layout>
     <x-slot name="header">
        <div>
            <h2 class="font-bold text-lg text-slate-800 leading-tight">
                Kelola Riwayat Pengiriman Pabrik
            </h2>
            <span class="text-xs font-medium text-slate-500 mt-1 block">
                Pantau status pengiriman tangki curah dan hasil uji mutu.
            </span>
        </div>
    </x-slot>
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Riwayat Pengiriman Pabrik
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Pantau status pengiriman tangki curah dan hasil uji mutu laboratorium dari PT HEN.</p>
                </div>
                <div>
                    <a href="{{ route('pengepul.pengiriman.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-emerald-200 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Kirim Minyak Baru
                    </a>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-wider font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">ID Pengiriman</th>
                                <th class="px-6 py-4">Tanggal Kirim</th>
                                <th class="px-6 py-4">Volume Bersih</th>
                                <th class="px-6 py-4">Hasil Uji Lab PT HEN</th>
                                <th class="px-6 py-4">Status Logistik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            
                            @forelse($riwayatPengiriman as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-blue-600 tracking-wide">TRX-HEN-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">Penyetor: <span class="text-slate-700 font-medium">{{ $item->masyarakat->name ?? 'Masyarakat' }}</span></div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-slate-600 font-medium">
                                        {{ $item->tanggal_penjemputan ? (\Carbon\Carbon::parse($item->tanggal_penjemputan)->format('d M Y')) : $item->created_at->format('d M Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 font-bold text-slate-900 text-base">
                                        {{ number_format($item->liter_bersih, 2) }} <span class="text-xs text-slate-400 font-normal">Liter</span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($item->status === 'selesai')
                                            <div class="text-xs space-y-1 bg-emerald-50 border border-emerald-200 p-2 rounded-lg max-w-[160px]">
                                                <div><span class="text-slate-500">FFA:</span> <span class="text-emerald-700 font-bold">1.2%</span> <span class="text-[10px] text-emerald-600 font-medium">(Lolos)</span></div>
                                                <div><span class="text-slate-500">Air:</span> <span class="text-emerald-700 font-bold">0.1%</span> <span class="text-[10px] text-emerald-600 font-medium">(Lolos)</span></div>
                                            </div>
                                        @elseif($item->status === 'ditolak')
                                            <div class="text-xs bg-rose-50 border border-rose-200 p-2 rounded-lg text-rose-700 font-bold max-w-[160px] flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Gagal Mutu Asam
                                            </div>
                                        @else
                                            <div class="text-xs bg-slate-50 border border-slate-200 p-2 rounded-lg text-slate-500 italic flex items-center gap-1.5 max-w-[160px]">
                                                <div class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-ping"></div>
                                                Proses Analisis...
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($item->status === 'dijemput')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 shadow-sm animate-pulse">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Pengecekan Mutu (HEN)
                                            </span>
                                        @elseif($item->status === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Diterima Industri
                                            </span>
                                        @elseif($item->status === 'ditolak')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200 shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak Pabrik
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 bg-slate-50/50">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125 .504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                            <p class="text-sm italic">Belum ada catatan atau riwayat alokasi pengiriman minyak ke PT HEN.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
</x-app-layout>