<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Hewan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('user.animals.update', $animal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Hewan</label>
                            <input type="text" name="name" value="{{ $animal->name }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jenis</label>
                                <input type="text" name="species" value="{{ $animal->species }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="Jantan" {{ $animal->gender == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                                    <option value="Betina" {{ $animal->gender == 'Betina' ? 'selected' : '' }}>Betina</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Berat (Kg)</label>
                                <input type="number" step="0.1" name="weight" value="{{ $animal->weight }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Perkiraan Usia</label>
                                <input type="text" name="estimated_age" value="{{ $animal->estimated_age }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                                <input type="number" name="price" value="{{ $animal->price }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Status Penjualan</label>
                                <select name="is_public" class="w-full border-gray-300 rounded-md shadow-sm text-blue-700 font-bold" required>
                                    <option value="1" {{ $animal->is_public == 1 ? 'selected' : '' }}>Tersedia</option>
                                    <option value="0" {{ $animal->is_public == 0 ? 'selected' : '' }}>Terjual</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ $animal->description }}</textarea>
                        </div>

                        <div class="mb-4 p-4 border rounded bg-gray-50">
                            <label class="block text-gray-700 font-bold mb-2">Foto Saat Ini:</label>
                            <img src="{{ asset('storage/' . $animal->image_path) }}" alt="Foto" class="h-32 mb-4 rounded">

                            <label class="block text-gray-700 font-bold mb-2">Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                            <input type="file" name="image" accept="image/*" class="w-full border-gray-300">
                        </div>

                        <div class="mt-6 flex gap-4">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Simpan Perubahan</button>
                            <a href="{{ route('user.animals.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
