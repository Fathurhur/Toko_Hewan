<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Hewan Dagangan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('user.animals.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    + Tambah Hewan Baru
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 items-start">
                @forelse ($animals as $animal)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('upload/animals/' . $animal->image_path) }}" alt="{{ $animal->name }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1 text-gray-900 leading-tight">{{ $animal->name }}</h3>
                            <p class="text-gray-600 text-xs mb-1"><strong>Jenis:</strong> {{ $animal->species }} ({{ $animal->gender }})</p>
                            <p class="text-gray-600 text-xs mb-1"><strong>Usia:</strong> {{ $animal->estimated_age }} | <strong>Berat:</strong> {{ $animal->weight }} Kg</p>
                            <p class="text-green-600 font-bold text-lg mt-2">Rp {{ number_format($animal->price, 0, ',', '.') }}</p>

                            <p class="text-xs mt-2 font-semibold {{ $animal->is_public ? 'text-green-600' : 'text-red-500' }}">
                                Status: {{ $animal->is_public ? 'Tersedia' : 'Terjual' }}
                            </p>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('user.animals.edit', $animal->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1.5 rounded text-xs flex-1 font-semibold transition text-center flex items-center justify-center">
                                    Edit
                                </a>

                                <form action="{{ route('user.animals.destroy', $animal->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full h-full bg-red-600 hover:bg-red-700 text-white px-2 py-1.5 rounded text-xs font-semibold transition text-center">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-md text-center text-gray-500">
                        Belum ada hewan yang Anda jual. Silakan tambah hewan baru!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
