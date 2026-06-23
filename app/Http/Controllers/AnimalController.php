<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin melihat semua hewan dari semua user
            $animals = Animal::with('user')->latest()->get();
            return view('admin.animals.index', compact('animals')); // Pastikan file ini nanti dibuat untuk admin
        } else {
            // User biasa hanya melihat hewannya sendiri
            $animals = $user->animals()->latest()->get();
            return view('user.animals.index', compact('animals'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('admin.animals.create');
        }
        return view('user.animals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari user
        $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string|max:255',
            'gender'        => 'required|in:Jantan,Betina',
            'weight'        => 'required|numeric',
            'estimated_age' => 'required|string|max:50',
            'price'         => 'required|numeric',
            'description'   => 'required|string',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Simpan gambar ke storage/app/public/animals menggunakan Storage facade
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Simpan file dan dapatkan path relatif terhadap storage/app/public
            $path = Storage::disk('public')->putFileAs('animals', $image, $imageName);
            // Path yang disimpan adalah 'animals/filename' (tanpa 'storage/' prefix)
            $imagePath = $path;
        }

        // 3. Simpan data ke database (Otomatis terkait dengan user yang sedang login)
        auth()->user()->animals()->create([
            'image_path'    => $imagePath,
            'name'          => $request->name,
            'species'       => $request->species,
            'gender'        => $request->gender,
            'weight'        => $request->weight,
            'estimated_age' => $request->estimated_age,
            'price'         => $request->price,
            'description'   => $request->description,
            'is_public'     => 1, // <--- TAMBAHKAN BARIS INI AGAR OTOMATIS "TERSEDIA"
        ]);

        // 4. Arahkan kembali ke halaman sesuai role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Hewan berhasil ditambahkan!');
        }
        return redirect()->route('user.animals.index')->with('success', 'Hewan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari data hewan berdasarkan ID
        $animal = Animal::findOrFail($id);

        // Pastikan penjual hanya bisa mengedit hewannya sendiri (kecuali Admin)
        if ($animal->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengedit hewan ini.');
        }

        // Buka halaman form edit sesuai role
        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('admin.animals.edit', compact('animal'));
        }
        return view('user.animals.edit', compact('animal'));
    }

    public function update(Request $request, string $id)
    {
        $animal = Animal::findOrFail($id);

        if ($animal->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengedit hewan ini.');
        }

        // 1. Validasi input (perhatikan kolom 'image' sekarang 'nullable' alias boleh kosong)
        $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string|max:255',
            'gender'        => 'required|in:Jantan,Betina',
            'weight'        => 'required|numeric',
            'estimated_age' => 'required|string|max:50',
            'price'         => 'required|numeric',
            'description'   => 'required|string',
            'is_public'     => 'required|boolean', // Validasi status tampil/terjual
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil semua data request kecuali gambar
        $data = $request->except(['image', '_token', '_method']);

        // 3. Jika user mengupload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage agar hard disk tidak penuh
            if ($animal->image_path && Storage::disk('public')->exists($animal->image_path)) {
                Storage::disk('public')->delete($animal->image_path);
            }

            // Simpan gambar baru ke storage/app/public/animals
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('animals', $image, $imageName);
            $data['image_path'] = $path;
        }

        // 4. Update data ke database
        $animal->update($data);

        // 5. Kembali ke dashboard dengan pesan sukses (Cek siapa yang sedang login)
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Tindakan Admin: Data hewan berhasil diperbarui!');
        }
        return redirect()->route('user.animals.index')->with('success', 'Data hewan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data hewan
        $animal = Animal::findOrFail($id);

        // Keamanan: Pastikan hanya pemiliknya (atau admin) yang boleh menghapus
        if ($animal->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menghapus hewan ini.');
        }

        // Hapus file gambar dari storage agar hard disk tidak penuh
        if ($animal->image_path && Storage::disk('public')->exists($animal->image_path)) {
            Storage::disk('public')->delete($animal->image_path);
        }

        // Hapus data dari database
        $animal->delete();

        // Kembalikan ke halaman index dengan pesan sukses
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Tindakan Admin: Hewan nakal berhasil dihapus paksa!');
        }
        return redirect()->route('user.animals.index')->with('success', 'Data hewan berhasil dihapus secara permanen!');
    }
}
