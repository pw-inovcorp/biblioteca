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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('livro_id')->constrained()->onDelete('cascade');
            $table->foreignId('requisicao_id')->constrained('requisicoes')->onDelete('cascade');
            $table->string('comment');
            $table->enum('status', ['suspenso', 'ativo', 'recusado'])->default('suspenso');
            $table->string('justificacao_recusa')->nullable();
            $table->timestamps();

            // Um cidadão só pode fazer um review por requisição(restrição)
            $table->unique(['user_id', 'requisicao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
