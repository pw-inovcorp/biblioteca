<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Livro;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_requisicao')->unique();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Livro::class);
            $table->date('data_requisicao');
            $table->date('data_prevista_entrega'); // sempre 5 dias após requisição
            $table->date('data_real_entrega')->nullable(); // preenchido quando devolver
            $table->enum('status', ['ativa', 'devolvida', 'atrasada'])->default('ativa');
            $table->integer('dias_decorridos')->nullable(); // calculado na devolução
            $table->string('foto_cidadao')->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
