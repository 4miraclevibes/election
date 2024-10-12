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
        Schema::create('tps_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_election_id')->constrained('tps_elections');
            $table->string('name');
            $table->string('address')->nullable();
            $table->enum('sex', ['L', 'P'])->nullable();
            $table->integer('age')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps_participants');
    }
};
