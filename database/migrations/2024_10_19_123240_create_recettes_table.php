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
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boulanger_id')->nullable()->constrained('boulangers');
            $table->enum('type_recette', ['PAYE', 'NONPAYE', 'SEMIPAYE', 'FERMER', 'EXONERER'])->default('NONPAYE');
            $table->float('montant')->default(0);
            $table->string('numeroFacture')->nullable(true);
            $table->date('date');
            $table->enum('month', ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMENBRE']);
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
        Schema::dropIfExists('recettes');
    }
};
