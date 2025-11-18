<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('vaults', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('category', 50);
            $table->text('encrypted_data'); // Client-side encrypted data
            $table->string('data_hash', 128); // SHA-512 for integrity check
            $table->string('version', 10)->default('1.0');
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'category']);
            $table->index('last_accessed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaults');
    }
};
