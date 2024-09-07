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
        Schema::create('quick_count_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quick_count_id')->constrained('quick_counts')->onDelete('cascade');
            $table->foreignId('candidate_election_id')->constrained('candidate_elections')->onDelete('cascade');
            $table->integer('vote_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_count_details');
    }
};
