<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pantai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_tiket', 8, 2);
            $table->tinyInteger('keindahan');      // 1-5
            $table->tinyInteger('aksesibilitas');  // 1-5
            $table->tinyInteger('fasilitas');      // 1-5
            $table->tinyInteger('aktivitas');      // 1-5
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pantai');
    }
};
