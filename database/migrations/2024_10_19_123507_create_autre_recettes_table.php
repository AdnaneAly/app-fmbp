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
        Schema::create('autre_recettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_recette_id')->constrained('type_recettes');
            $table->foreignId('created_by')->constrained('users');
            $table->float('montant');
            $table->string('numeroFacture')->nullable(true);
            $table->dateTime('date');
            $table->longText('description')->nullable(true);
            $table->string('annee');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autre_recettes');
    }
};
