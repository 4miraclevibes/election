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
        Schema::create('tps_elections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_invitation');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelurahan_election_id')->constrained('kelurahan_elections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps_elections');
    }
};
