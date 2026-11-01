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
        Schema::create('voter_credentials', function (Blueprint $table) {

            $table->id();

            $table->foreignId('election_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('voter_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('token_hash')->unique();

            $table->enum('status', [
                'active',
                'used',
                'expired',
                'revoked'
            ])->default('active');

            $table->timestamp('expires_at')->nullable();

            $table->timestamp('used_at')->nullable();

            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->unique('voter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voter_credentials');
    }
};
