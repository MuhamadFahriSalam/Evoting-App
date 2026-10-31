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
        Schema::create('voters', function (Blueprint $table) {

            $table->id();

            $table->foreignId('election_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('voter_identifier');

            $table->string('name');

            $table->enum('eligibility_status', [
                'eligible',
                'ineligible'
            ])->default('eligible');

            $table->foreignId('polling_station_id')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'election_id',
                'voter_identifier'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
