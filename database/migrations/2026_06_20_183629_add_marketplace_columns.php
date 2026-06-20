<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambah kolom WhatsApp di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('email');
        });

        // Menambah kolom status tampil di tabel animals
        Schema::table('animals', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('whatsapp_number');
        });

        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
};
