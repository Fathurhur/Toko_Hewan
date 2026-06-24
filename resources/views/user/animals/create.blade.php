<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Hewan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('user.animals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Hewan</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jenis (Kucing, Anjing, dll)</label>
                                <input type="text" name="species" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="Jantan">Jantan</option>
                                    <option value="Betina">Betina</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Berat (Kg)</label>
                                <input type="number" step="0.1" name="weight" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Perkiraan Usia</label>
                                <input type="text" name="estimated_age" placeholder="Contoh: 3 Bulan" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                            <input type="text" name="price" placeholder="Contoh: 200000" class="w-full border-gray-300 rounded-md shadow-sm price-input" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Foto Hewan</label>
                            <input type="file" name="image" accept="image/*" class="w-full border-gray-300" required>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Simpan Data</button>
                        </div>
                    </form>

                    <script>
                        // Format price input saat user mengetik
                        document.querySelector('.price-input').addEventListener('input', function(e) {
                            let value = e.target.value.replace(/\D/g, ''); // Hapus semua karakter bukan angka
                            if (value) {
                                e.target.value = new Intl.NumberFormat('id-ID').format(value);
                            }
                        });

                        // Normalize price sebelum submit (hapus formatting)
                        document.querySelector('form').addEventListener('submit', function(e) {
                            let priceInput = document.querySelector('.price-input');
                            priceInput.value = priceInput.value.replace(/\D/g, ''); // Hanya simpan angka
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
