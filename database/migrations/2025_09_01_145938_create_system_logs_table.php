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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('data_hora');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('modulo');
            $table->unsignedBigInteger('objeto_id')->nullable();
            $table->text('alteracao')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('browser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
