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
        Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeur_id')->constrained('employeurs');
            $table->foreignId('created_by')->constrained('users');
            $table->float('nombreJoursTravail');
            $table->float('montantJoursTravail');
            $table->float('salaireNet');
            $table->dateTime('date');
            $table->string('annee');
            $table->longText('description')->nullable(true);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaires');
    }
};
