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
        Schema::create('kuas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama KUA
            $table->text('address'); // Alamat lengkap
            $table->string('phone')->nullable(); // Nomor telepon
            $table->string('email')->nullable(); // Email KUA
            $table->string('operating_hours')->nullable(); // Jam operasional
            $table->text('google_maps_link')->nullable(); // Link Google Maps untuk directions
            $table->text('google_maps_embed')->nullable(); // Embed URL untuk iframe
            $table->boolean('is_active')->default(true); // Status aktif atau tidak
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuas');
    }
};
