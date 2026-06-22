<x-guest-layout>
    <div x-data="{ isLogin: {{ request()->routeIs('login') ? 'true' : 'false' }} }" class="w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden grid grid-cols-1 md:grid-cols-12 min-h-[600px] border border-slate-100">
        
        <div class="md:col-span-5 bg-emerald-600 p-8 flex flex-col justify-between text-white relative overflow-hidden bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-500 via-emerald-600 to-emerald-700">
            <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-emerald-500/20 blur-xl"></div>
            <div class="absolute -left-10 -bottom-10 w-40 h-40 rounded-full bg-emerald-800/30 blur-xl"></div>
            
            <div class="relative z-10">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg overflow-hidden backdrop-blur-sm shrink-0 shadow-sm">
            <img src="{{ asset('images/logo.png') }}" alt="Logo JetOil" class="w-full h-full object-cover">
        </div>
        <span class="text-xl font-extrabold tracking-tight text-white">JetOil</span>
    </div>
    <p class="text-[11px] text-emerald-200 uppercase tracking-wider font-semibold">PT Hijau Energi Nusantara</p>
</div>

            <div class="my-12 relative z-10">
                <div x-show="isLogin" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h3 class="text-2xl font-bold mb-3">Selamat Datang Kembali!</h3>
                    <p class="text-sm text-emerald-100/90 leading-relaxed">
                        Silakan masuk untuk mengelola pengumpulan minyak jelantah, memvalidasi data tangki, atau mengakses dasbor analisis AI.
                    </p>
                </div>
                <div x-show="!isLogin" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h3 class="text-2xl font-bold mb-3">Mulai Langkah Hijaumu</h3>
                    <p class="text-sm text-emerald-100/90 leading-relaxed">
                        Daftarkan akun ekosistem avtur ramah lingkungan (SAF) Anda sekarang. Pilih peran sebagai penyetor atau mitra pengepul.
                    </p>
                </div>
            </div>

            <div class="bg-emerald-800/40 p-1.5 rounded-2xl border border-white/10 relative z-10">
                <div class="grid grid-cols-2 gap-1 relative">
                    <button type="button" @click="isLogin = true; window.history.pushState(null, null, '{{ route('login') }}')" 
                        :class="isLogin ? 'bg-white text-emerald-700 shadow-md font-bold' : 'text-emerald-100 hover:text-white font-medium'" 
                        class="py-3 text-center rounded-xl text-sm transition-all duration-300">
                        Masuk (Login)
                    </button>
                    <button type="button" @click="isLogin = false; window.history.pushState(null, null, '{{ route('register') }}')" 
                        :class="!isLogin ? 'bg-white text-emerald-700 shadow-md font-bold' : 'text-emerald-100 hover:text-white font-medium'" 
                        class="py-3 text-center rounded-xl text-sm transition-all duration-300">
                        Daftar (Register)
                    </button>
                </div>
            </div>
        </div>

        <div class="md:col-span-7 p-8 sm:p-12 flex flex-col justify-center bg-white relative">
            
            <div x-show="isLogin" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Gerbang Akses Sistem</h2>
                    <p class="text-sm text-slate-500 mt-1">Masukkan kredensial terdaftar Anda untuk masuk ke sistem.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="login_email" :value="__('Alamat Email')" class="text-slate-700 font-medium" />
                        <x-text-input id="login_email" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="login_password" :value="__('Kata Sandi')" class="text-slate-700 font-medium" />
                            @if (Route::has('password.request'))
                                <a class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 underline underline-offset-4" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <x-text-input id="login_password" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                            <span class="ms-2 text-sm text-slate-600">Ingat perangkat saya</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-xl transition-all shadow-lg shadow-emerald-100">
                            Masuk Masuk Ke Dashboard
                        </button>
                    </div>
                </form>
            </div>

            <div x-show="!isLogin" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Buat Akun Ekosistem</h2>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi form pendaftaran peran rantai pasok HEN di bawah.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="reg_name" :value="__('Nama Lengkap / Instansi')" class="text-slate-700 font-medium" />
                        <x-text-input id="reg_name" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="text" name="name" :value="old('name')" required autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="reg_email" :value="__('Alamat Email')" class="text-slate-700 font-medium" />
                        <x-text-input id="reg_email" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Pilih Hak Akses Peran')" class="text-slate-700 font-medium text-emerald-600" />
                        <select id="role" name="role" required class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm p-2.5 bg-slate-50 font-medium text-slate-800">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran Anda --</option>
                            <option value="masyarakat" {{ old('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat / Penyetor Minyak Hulu</option>
                            <option value="pengepul" {{ old('role') == 'pengepul' ? 'selected' : '' }}>Mitra Gudang Pengepul Juri</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="reg_password" :value="__('Kata Sandi Baru')" class="text-slate-700 font-medium" />
                        <x-text-input id="reg_password" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-700 font-medium" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl transition-all shadow-md">
                            Daftar Sekarang & Kontribusi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>