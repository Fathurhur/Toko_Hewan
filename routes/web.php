<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Models\Animal;

// 1. Halaman Depan (Marketplace Umum)
Route::get('/', function () {
    $animals = Animal::with('user')->latest()->get();
    return view('welcome', compact('animals'));
});

Route::middleware('auth')->group(function () {

    // 2. Pengatur Lalu Lintas Utama (Saat Login)
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // User (Penjual) langsung dilempar ke halaman CRUD Hewan miliknya
        return redirect()->route('user.animals.index');
    })->name('dashboard');

    // 3. Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -----------------------------------------------------
    // 4. DASHBOARD ADMIN
    // -----------------------------------------------------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () {
            // Hanya mengambil data Hewan dan Pedagang saja
            $animals = \App\Models\Animal::with('user')->latest()->get();
            $sellers = \App\Models\User::where('role', 'user')->latest()->get();

            return view('admin.dashboard', compact('animals', 'sellers'));
        })->name('dashboard');

        Route::resource('animals', AnimalController::class);

        // Rute kelola admin pembantu sudah dihapus dari sini
    });


    // -----------------------------------------------------
    // 5. DASHBOARD USER (PENJUAL)
    // -----------------------------------------------------
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        // Halaman dashboard kosong (bawaan) dibiarkan utuh buat jaga-jaga
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        // Halaman CRUD Utama Penjual
        Route::resource('animals', AnimalController::class);
    });
});

require __DIR__.'/auth.php';
