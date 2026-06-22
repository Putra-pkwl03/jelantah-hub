<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 w-full">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-sm text-gray-600">
            {{ __("Update your account's profile information, email address, and operational location.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <hr class="border-gray-200 my-4">

        <!-- ==================== INTEGRASI MAPS JELANTAHHUB ==================== -->
        <!-- Alamat Lengkap -->
        <div>
            <x-input-label for="address" value="Alamat Lengkap (Rumah/UMKM/Pos Pengepul)" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required placeholder="Contoh: Jl. Merdeka No. 12, RT 02/RW 05" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Baris Input Koordinat (Readonly agar aman) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="latitude" value="Latitude" />
                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full bg-gray-50 cursor-not-allowed" :value="old('latitude', $user->latitude)" readonly required />
                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
            </div>
            <div>
                <x-input-label for="longitude" value="Longitude" />
                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full bg-gray-50 cursor-not-allowed" :value="old('longitude', $user->longitude)" readonly required />
                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
            </div>
        </div>

        <!-- Pemilih Peta -->
        <div>
            <label class="block font-medium text-sm text-gray-700 mb-2">Titik Lokasi Peta</label>
            
            @if($user->role !== 'stakeholder')
                <button type="button" onclick="getLocationProfil()" class="mb-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    📍 Deteksi GPS Saya Otomatis
                </button>
            @endif

            <!-- Elemen untuk merender Peta -->
            <div id="mapProfile" class="w-full h-64 rounded-lg border border-gray-300 shadow-inner" style="height: 250px; z-index: 1;"></div>
            <p class="text-xs text-gray-500 mt-2 italic">*Geser pin merah ke lokasi yang tepat jika pencarian otomatis kurang akurat.</p>
        </div>
        <!-- ==================== END INTEGRASI MAPS ==================== -->

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<!-- IMPORT LEAFLET MAPS ASSETS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Jika user sudah punya koordinat pakai itu, jika kosong default ke pusat peta Indonesia (Jakarta)
        var latAwal = {{ $user->latitude ?? -6.200000 }};
        var lngAwal = {{ $user->longitude ?? 106.816666 }};
        var zoomAwal = {{ $user->latitude ? 15 : 5 }};

        // Render Peta ke elemen #mapProfile
        var mapProf = L.map('mapProfile').setView([latAwal, lngAwal], zoomAwal);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapProf);

        // Buat Marker/Pin Merah yang Draggable (Bisa digeser)
        var penandaMasyarakat = L.marker([latAwal, lngAwal], {
            draggable: true
        }).addTo(mapProf);

        // Fungsi memperbarui isi input form latitude & longitude
        function updateFormFields(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }

        // Jalankan update jika koordinat default sudah terisi sejak awal beban halaman
        if({{ $user->latitude ? 'true' : 'false' }}) {
            updateFormFields(latAwal, lngAwal);
        }

        // Tangkap event ketika pin selesai digeser manual oleh user
        penandaMasyarakat.on('dragend', function (e) {
            var koordinatBaru = penandaMasyarakat.getLatLng();
            updateFormFields(koordinatBaru.lat, koordinatBaru.lng);
        });

        // Handler Tombol Otomatis GPS Browser
        window.getLocationProfil = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var gpsLat = position.coords.latitude;
                    var gpsLng = position.coords.longitude;

                    penandaMasyarakat.setLatLng([gpsLat, gpsLng]);
                    mapProf.setView([gpsLat, gpsLng], 16);
                    updateFormFields(gpsLat, gpsLng);
                }, function () {
                    alert("Gagal membaca GPS. Silakan geser pin merah di peta secara manual.");
                });
            } else {
                alert("Browser Anda tidak mendukung fitur Geolocation.");
            }
        }
    });
</script>