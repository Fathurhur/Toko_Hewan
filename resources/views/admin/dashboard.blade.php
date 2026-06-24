<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <h3 class="text-lg font-bold mb-4">Daftar Hewan yang Dijual pedagang</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Foto</th>
                                    <th class="px-6 py-3">Nama Hewan</th>
                                    <th class="px-6 py-3">Jenis</th>
                                    <th class="px-6 py-3">Penjual</th>
                                    <th class="px-6 py-3">Harga</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-left w-1/4">Deskripsi</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($animals as $animal)
                                <tr class="border-b hover:bg-gray-50 items-center">
                                    <td class="px-6 py-2">
                                        @if($animal->image_path)
                                            <img src="{{ asset('uploads/animals/' . $animal->image_path) }}" alt="Foto" class="w-16 h-16 object-cover rounded shadow-sm border border-gray-200">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 flex items-center justify-center rounded border border-gray-200 text-xs text-gray-400">No Pic</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $animal->name }}</td>
                                    <td class="px-6 py-4">{{ $animal->species }}</td>
                                    <td class="px-6 py-4 font-bold text-blue-600">{{ $animal->user->name }}</td>
                                    <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($animal->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 font-semibold {{ $animal->is_public ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $animal->is_public ? 'Tersedia' : 'Kosong' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 text-left align-middle break-words">
                                        {{ \Illuminate\Support\Str::limit($animal->description, 60, '...') }}
                                    </td>
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('admin.animals.edit', $animal->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.animals.destroy', $animal->id) }}" method="POST" onsubmit="return confirm('TINDAKAN ADMIN: Yakin ingin menghapus paksa hewan ini dari marketplace?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <h3 class="text-lg font-bold mb-4">Daftar Akun Pedagang</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Nama</th>
                                    <th class="px-6 py-3">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $seller)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $seller->name }}</td>
                                    <td class="px-6 py-4">{{ $seller->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
