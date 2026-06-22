<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Gerbang Kendali Mutu & Otorisasi SAF') }}
            </h2>
            <span class="block text-xs text-slate-500 mt-1 font-medium">
                Pusat Otorisasi volume final untuk standardisasi bahan baku Sustainable Aviation Fuel (SAF).
            </span>
        </div>
    </div>
</x-slot>

    <div x-data="{ 
        openLabModal: false, 
        openOtorisasiModal: false,
        selectedId: '', 
        pengepulName: '', 
        volumeKirim: '', 
        gradeTerhitung: '',
        actionUrl: '' 
    }" class=" font-sans">
        
        <div class="max-w-7xl space-y-4">

            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-1 bg-emerald-500 rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-1 bg-rose-500 rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition duration-200">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Grade A (Premium SAF)</span>
                    <p class="text-sm font-semibold text-emerald-600 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Air ≤ 0.15% | FFA ≤ 1.5% | Kotoran ≤ 0.02%
                    </p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition duration-200">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Grade B (Standar)</span>
                    <p class="text-sm font-semibold text-sky-600 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-sky-500 mr-2"></span> Air ≤ 0.50% | FFA ≤ 3.0% | Kotoran ≤ 0.05%
                    </p>
                </div>
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition duration-200">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Grade C / Reject</span>
                    <p class="text-sm font-semibold text-rose-600 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-rose-500 mr-2"></span> Melebihi Batas Toleransi / Olah Ulang
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base tracking-tight">Daftar Antrean Setoran Pengepul Hub</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Alur Berjenjang: Jalur Pengujian Kimia Laboratorium & Kelayakan Muatan Tangki Pabrik.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 pl-6">ID / Tanggal</th>
                                <th class="p-4">Nama Pengepul</th>
                                <th class="p-4 text-right">Volume Awal</th>
                                <th class="p-4 text-center">Hasil Mutu (Grade)</th>
                                <th class="p-4 text-center">Status Gerbang</th>
                                <th class="p-4 text-center pr-6">Alur Kerja Otorisasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                            @forelse($antreanSetoran as $setoran)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 pl-6 font-mono text-xs text-slate-500">
                                    <span class="font-bold text-slate-700">#TRX-{{ $setoran->id }}</span><br>
                                    <span class="text-slate-400" style="font-size: 10px;">{{ $setoran->created_at->translatedFormat('d F Y') }}</span>
                                </td>
                                <td class="p-4 font-semibold text-slate-900">
                                    {{ $setoran->pengepul->name ?? 'Pengepul Tidak Ditemukan' }}
                                </td>
                                <td class="p-4 text-right font-bold text-slate-800">
                                    {{ number_format($setoran->liter_bersih ?? $setoran->liter_estimasi) }} L
                                </td>
                                
                                <td class="p-4 text-center">
                                    @if($setoran->grade)
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg 
                                            {{ str_contains($setoran->grade, 'Grade A') ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                                            {{ str_contains($setoran->grade, 'Grade B') ? 'bg-sky-50 text-sky-800 border border-sky-200' : '' }}
                                            {{ str_contains($setoran->grade, 'Reject') || str_contains($setoran->grade, 'Grade C') ? 'bg-rose-50 text-rose-800 border border-rose-200' : '' }}">
                                            {{ $setoran->grade }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium rounded-lg">Belum Diuji</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    @if($setoran->status == 'selesai')
                                        <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-medium rounded-full">Diterima ({{ $setoran->liter_final }}L)</span>
                                    @elseif($setoran->status == 'ditolak')
                                        <span class="px-2.5 py-1 bg-rose-50 border border-rose-100 text-rose-700 text-xs font-medium rounded-full">Ditolak</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-medium rounded-full">Antrean Masuk</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center pr-6">
                                    @if(is_null($setoran->grade))
                                        <button 
                                            @click="openLabModal = true; 
                                                    selectedId = '{{ $setoran->id }}'; 
                                                    pengepulName = '{{ addslashes($setoran->pengepul->name ?? 'Pengepul') }}'; 
                                                    volumeKirim = '{{ $setoran->liter_bersih ?? $setoran->liter_estimasi }}';
                                                    actionUrl = '{{ route('stakeholder.updateLab', $setoran->id) }}'"
                                            class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-200"
                                        >
                                            🧪 1. Analisis Uji Lab
                                        </button>
                                    @elseif($setoran->status == 'proses' || $setoran->status == 'dijemput')
                                        <button 
                                            @click="openOtorisasiModal = true; 
                                                    selectedId = '{{ $setoran->id }}'; 
                                                    pengepulName = '{{ addslashes($setoran->pengepul->name ?? 'Pengepul') }}'; 
                                                    volumeKirim = '{{ $setoran->liter_bersih ?? $setoran->liter_estimasi }}';
                                                    gradeTerhitung = '{{ $setoran->grade }}';
                                                    actionUrl = '{{ route('stakeholder.updateOtorisasi', $setoran->id) }}'"
                                            class="inline-flex items-center px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-200"
                                        >
                                            🔑 2. Otorisasi Rilis
                                        </button>
                                    @else
                                        <span class="text-xs font-medium text-slate-400 italic">Berkas Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">
                                    Tidak ada antrean logistik baru saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($antreanSetoran->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $antreanSetoran->links() }}
                </div>
                @endif
            </div>
        </div>

        <div x-show="openLabModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
            <div x-show="openLabModal" x-transition class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            <div x-show="openLabModal" x-transition @click.away="openLabModal = false" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-100 z-10">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">🧪 Tahap 1: Analisis Spesifikasi Lab</h3>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="'Kalkulasi Standar Mutu SAF #' + selectedId"></p>
                    </div>
                </div>

                <form :action="actionUrl" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-3.5 bg-slate-50 rounded-xl text-xs space-y-1">
                        <p class="text-slate-600">Hub Pengirim: <span class="font-bold text-slate-900" x-text="pengepulName"></span></p>
                        <p class="text-slate-600">Kuantitas Nota: <span class="font-bold text-slate-900" x-text="volumeKirim + ' Liter'"></span></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Metrik Uji Titrasi Fisik</label>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="relative">
                                <span class="absolute right-2 top-2 text-xs font-medium text-slate-400">%</span>
                                <input type="number" step="0.01" min="0" max="100" name="kadar_air" class="w-full pr-6 rounded-xl border-slate-200 text-sm font-semibold focus:ring-slate-900" placeholder="Air" required>
                                <span class="block style text-slate-400 mt-1 pl-1" style="font-size: 10px;">Kadar Air</span>
                            </div>
                            <div class="relative">
                                <span class="absolute right-2 top-2 text-xs font-medium text-slate-400">%</span>
                                <input type="number" step="0.01" min="0" max="100" name="ffa" class="w-full pr-6 rounded-xl border-slate-200 text-sm font-semibold focus:ring-slate-900" placeholder="FFA" required>
                                <span class="block text-slate-400 mt-1 pl-1" style="font-size: 10px;">Kadar FFA</span>
                            </div>
                            <div class="relative">
                                <span class="absolute right-2 top-2 text-xs font-medium text-slate-400">%</span>
                                <input type="number" step="0.01" min="0" max="100" name="kotoran" class="w-full pr-6 rounded-xl border-slate-200 text-sm font-semibold focus:ring-slate-900" placeholder="Kotoran" required>
                                <span class="block text-slate-400 mt-1 pl-1" style="font-size: 10px;">Kotoran</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end space-x-2">
                        <button type="button" @click="openLabModal = false" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-semibold shadow-sm">Kunci Batas & Hitung Grade</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="openOtorisasiModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
            <div x-show="openOtorisasiModal" x-transition class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            <div x-show="openOtorisasiModal" x-transition @click.away="openOtorisasiModal = false" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-100 z-10">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">🔑 Tahap 2: Keputusan Komersial & Tangki</h3>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="'Otorisasi Gerbang Pabrik #' + selectedId"></p>
                    </div>
                </div>

                <form :action="actionUrl" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-4 bg-indigo-50/60 rounded-2xl border border-indigo-100 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Sertifikasi Laboratorium:</span>
                            <span class="font-bold text-indigo-700 bg-white px-2 py-0.5 rounded border border-indigo-200" x-text="gradeTerhitung"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kapasitas Maksimal Nota:</span>
                            <span class="font-extrabold text-slate-800" x-text="volumeKirim + ' L'"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kebijakan Gerbang Masuk</label>
                        <select name="status_validasi" class="w-full rounded-xl border-slate-200 text-sm font-medium focus:ring-slate-900 bg-white">
                            <option value="terima" class="text-emerald-600 font-semibold">🟢 TERIMA (Muat ke Storage Nasional Pabrik)</option>
                            <option value="tolak" class="text-rose-600 font-semibold">🔴 REJECT (Batalkan Masuk & Kembalikan Truk)</option>
                        </select>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Netto Komersial Akhir (`liter_final`)</label>
                        </div>
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" name="liter_final" class="w-full pr-12 rounded-xl border-slate-200 text-sm font-bold text-slate-900 focus:ring-slate-900" placeholder="Masukkan volume akhir penyaringan pabrik">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-xs font-semibold">Liter</span>
                            </div>
                        </div>
                        <span class="block text-slate-400 mt-1 pl-1" style="font-size: 10px;">*Isi angka volume ini jika memilih opsi TERIMA. Angka tidak boleh melebihi kuantitas awal pengepul.</span>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end space-x-2">
                        <button type="button" @click="openOtorisasiModal = false" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-sm">Rilis Otorisasi Resmi</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>