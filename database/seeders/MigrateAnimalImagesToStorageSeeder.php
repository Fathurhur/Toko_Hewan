<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MigrateAnimalImagesToStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua hewan dari database
        $animals = Animal::all();
        $migratedCount = 0;
        $failedCount = 0;

        foreach ($animals as $animal) {
            // Skip jika image_path kosong
            if (!$animal->image_path) {
                continue;
            }

            // Skip jika image_path sudah dalam format storage (animals/filename)
            if (str_starts_with($animal->image_path, 'animals/')) {
                continue;
            }

            // Cek apakah file masih ada di public folder
            $oldPath = public_path($animal->image_path);
            if (!file_exists($oldPath)) {
                $failedCount++;
                continue;
            }

            try {
                // Baca file dari public folder
                $fileContent = file_get_contents($oldPath);

                // Ekstrak nama file dari path lama
                $fileName = basename($animal->image_path);

                // Simpan ke storage/app/public/animals
                $newPath = 'animals/' . $fileName;
                Storage::disk('public')->put($newPath, $fileContent);

                // Update database dengan path baru
                $animal->update(['image_path' => $newPath]);

                // Hapus file lama dari public folder
                unlink($oldPath);

                $migratedCount++;
                $this->command->line("✓ Migrated: {$animal->name} -> {$newPath}");
            } catch (\Exception $e) {
                $failedCount++;
                $this->command->error("✗ Failed: {$animal->name} - " . $e->getMessage());
            }
        }

        $this->command->info("\n=== Migration Summary ===");
        $this->command->info("Migrated: $migratedCount images");
        $this->command->warn("Failed: $failedCount images");
        $this->command->info("Total: " . ($migratedCount + $failedCount) . " images processed");
    }
}
