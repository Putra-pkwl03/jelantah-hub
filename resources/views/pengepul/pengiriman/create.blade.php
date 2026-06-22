<x-app-layout>
     <x-slot name="header">
        <div>
            <h2 class="font-bold text-lg text-slate-800 leading-tight">
                Kelola Pengiriman Minyak ke PT HEN
            </h2>
            <span class="text-xs font-medium text-slate-500 mt-1 block">
                Kirim akumulasi minyak dari gudang ke laboratorium.
            </span>
        </div>
    </x-slot>
        <div class="max-w-7xl mx-auto space-y-4">
            
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <span class="font-bold">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Kirim Minyak ke PT HEN</h2>
                    <p class="text-sm text-slate-500 mt-1">Kirim akumulasi minyak dari gudang pengepul ke laboratorium industri pusat.</p>
                </div>
                
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex gap-4 items-center">
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/><path d="M12 13.5a3 3 0 100-6 3 3 0 000 6z"/></svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Stok Siap Kirim</span>
                        <span class="text-lg font-bold text-slate-800">{{ number_format($totalStokTersedia, 1) }} Liter</span>
                    </div>
                </div>
            </div>

            <hr class="border-slate-200">

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <form action="{{ route('pengepul.pengiriman.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="volume" class="block text-sm font-medium text-slate-700 mb-2">Volume yang Dikirim</label>
                            <div class="relative rounded-xl shadow-sm">
                                <input type="number" step="0.01" name="volume" id="volume" max="{{ $totalStokTersedia }}"
                                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 pr-16 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 sm:text-sm transition-all" 
                                    placeholder="Maks: {{ $totalStokTersedia }}" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-sm font-semibold">
                                    Liter
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="no_kendaraan" class="block text-sm font-medium text-slate-700 mb-2">No. Kendaraan Pengirim</label>
                            <input type="text" name="no_kendaraan" id="no_kendaraan" 
                                class="block w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 sm:text-sm transition-all" 
                                placeholder="Contoh: B 1234 ABC" required>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-500 block">Harga Acuan Pengepul Anda:</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($hargaPengepul, 0, ',', '.') }} / Liter</span>
                        </div>
                        <div class="text-right">
                            <span class="text-slate-500 block">Estimasi Nilai Alokasi:</span>
                            <span id="label-total" class="font-bold text-emerald-600 text-base">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" @if($totalStokTersedia <= 0) disabled class="opacity-50 cursor-not-allowed px-5 py-2.5 rounded-xl bg-slate-400 text-white font-semibold text-sm shadow-md" @else class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-semibold text-sm shadow-md shadow-emerald-100 transition-all" @endif>
                            Konfirmasi Pengiriman Gudang
                        </button>
                    </div>
                </form>
            </div>
    </div>

    <script>
        document.getElementById('volume').addEventListener('input', function() {
            const vol = parseFloat(this.value) || 0;
            const total = vol * {{ $hargaPengepul }};
            document.getElementById('label-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    </script>
</x-app-layout>