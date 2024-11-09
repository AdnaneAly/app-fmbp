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
        Schema::create('employeurs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('grade_id')->constrained('grades');
            $table->float('montantSalaire');
            $table->string('nni')->nullable();
            $table->string('tel')->nullable();
            $table->date('date');
            $table->enum('etat',['active', 'noActive'])->default('active');
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
        Schema::dropIfExists('employeurs');
    }
};
