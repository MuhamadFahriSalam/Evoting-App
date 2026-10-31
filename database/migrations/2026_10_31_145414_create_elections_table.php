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
        Schema::create('elections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('village_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->enum('status', [
                'draft',
                'preparation',
                'scheduled',
                'active',
                'paused',
                'completed',
                'cancelled'
            ])->default('draft');

            $table->boolean('results_visibility')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elections');
    }
};
