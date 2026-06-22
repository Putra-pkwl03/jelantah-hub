<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center pb-2 border-b border-slate-100">
            <div>
                <h2 class="font-black text-2xl text-slate-900 tracking-tight">
                    {{ __('Pengaturan Akun Pengguna') }}
                </h2>
                <span class="block text-xs text-slate-400 mt-1 font-medium tracking-wide">
                    Personal Kredensial keamanan autentikasi, dan otorisasi hak akses peran Anda.
                </span>
            </div>
        </div>
    </x-slot>

    <div class="w-full bg-slate-50/30">
        <div class="w-full space-y-4">
            
            @if (session('warning'))
                <div class="p-4 bg-amber-50/80 backdrop-blur border border-amber-200 rounded-2xl shadow-sm flex items-start gap-3 animate-fade-in">
                    <span class="p-1 bg-amber-100 text-amber-700 rounded-lg shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </span>
                    <div>
                        <span class="font-bold text-amber-900 text-sm block">Perhatian Keamanan!</span>
                        <p class="text-xs text-amber-700/90 font-medium mt-0.5">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white border border-slate-100 rounded-3xl shadow-xs overflow-hidden transition-all duration-200 hover:shadow-sm">
                <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/40 flex items-center gap-3">
                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm tracking-tight">Informasi Umum Akun</h3>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl shadow-xs overflow-hidden transition-all duration-200 hover:shadow-sm">
                <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/40 flex items-center gap-3">
                    <span class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm tracking-tight">Pembaruan Kata Sandi</h3>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="w-full">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl shadow-xs overflow-hidden transition-all duration-200 hover:shadow-sm">
                <div class="px-6 py-4 border-b border-slate-50 bg-rose-50/20 flex items-center gap-3">
                    <span class="p-2 bg-rose-50 text-rose-600 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-bold text-rose-900 text-sm tracking-tight">Zona Bahaya (Destruktif)</h3>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="w-full">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>