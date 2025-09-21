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
        Schema::create('marriages', function (Blueprint $table) {
            $table->id();
            
            // Groom information
            $table->string('groom_nik', 16);
            $table->string('groom_name');
            $table->date('groom_birth_date');
            $table->string('groom_birth_place');
            $table->text('groom_address');
            
            // Bride information
            $table->string('bride_nik', 16);
            $table->string('bride_name');
            $table->date('bride_birth_date');
            $table->string('bride_birth_place');
            $table->text('bride_address');
            
            // Marriage information
            $table->date('marriage_date');
            $table->string('marriage_place');
            $table->string('witness1_name');
            $table->string('witness2_name');
            
            // Status and tracking
            $table->enum('status', ['active', 'inactive', 'cancelled'])->default('active');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['groom_nik', 'bride_nik']);
            $table->index('marriage_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriages');
    }
};
