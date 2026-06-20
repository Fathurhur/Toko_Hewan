<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace Hewan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-extrabold text-blue-700">PasarHewan</h1>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Dashboard Saya</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold mr-4">Log in Penjual</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 font-semibold">Daftar Penjual</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Hewan Terbaru yang Tersedia</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 items-start">
            @forelse ($animals as $animal)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('storage/' . $animal->image_path) }}" alt="{{ $animal->name }}" class="w-full h-full object-cover">
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1 text-gray-900 leading-tight">{{ $animal->name }}</h3>
                        <p class="text-gray-600 text-xs mb-1"><strong>Jenis:</strong> {{ $animal->species }} ({{ $animal->gender }})</p>
                        <p class="text-gray-600 text-xs mb-1"><strong>Usia:</strong> {{ $animal->estimated_age }} | <strong>Berat:</strong> {{ $animal->weight }} Kg</p>
                        <p class="text-green-600 font-bold text-lg mt-2">Rp {{ number_format($animal->price, 0, ',', '.') }}</p>

                        <p class="text-gray-500 text-xs mt-2 border-t pt-2">
                            Penjual: <strong>{{ $animal->user->name }}</strong>
                        </p>

                        <div class="mt-4">
                            @php
                                // Logika untuk memperbaiki format nomor WA (jika diinput 08, diubah jadi 62)
                                $wa = $animal->user->whatsapp_number;
                                if(substr($wa, 0, 1) == '0'){
                                    $wa = '62' . substr($wa, 1);
                                }
                                // Teks otomatis untuk pesan WhatsApp
                                $pesan = "Halo " . $animal->user->name . ", saya tertarik dengan " . $animal->name . " yang Anda jual dengan harga Rp " . number_format($animal->price, 0, ',', '.') . ". Apakah masih tersedia?";
                            @endphp

                            <a href="https://wa.me/{{ $wa }}?text={{ urlencode($pesan) }}" target="_blank" class="block w-full bg-green-500 hover:bg-green-600 text-white text-center px-4 py-2 rounded text-sm font-bold transition">
                                Hubungi Penjual (WhatsApp)
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-6 rounded-lg shadow-md text-center text-gray-500">
                    Belum ada hewan yang dijual saat ini.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
