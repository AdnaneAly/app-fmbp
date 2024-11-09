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
        Schema::create('depences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_depence_id')->constrained('type_depences');
            $table->foreignId('employeur_id')->nullable()->constrained('employeurs');
            $table->foreignId('created_by')->constrained('users');
            $table->float('montant');
            $table->string('numeroFacture')->nullable(true);
            $table->dateTime('date');
            $table->string('annee',4);
            $table->longText('description')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depences');
    }
};
