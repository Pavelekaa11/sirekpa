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
        Schema::create('preferensi_pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->tinyInteger('keindahan');
            $table->tinyInteger('aksesibilitas');
            $table->tinyInteger('fasilitas');
            $table->tinyInteger('aktivitas');
            $table->decimal('harga_tiket_max', 8, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_pengguna');
    }
};
