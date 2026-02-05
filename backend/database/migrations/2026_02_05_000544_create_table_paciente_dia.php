<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paciente_dia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_pk')
                ->constrained('paciente')
                ->cascadeOnDelete();
            $table->boolean('chegou')->default(false);
            $table->boolean('chamado')->default(false);
            $table->boolean('chamado_painel')->default(false);
            $table->boolean('chamar_acompanhante')->default(false);
            $table->unsignedTinyInteger('sala_dia')->nullable();
            $table->unsignedTinyInteger('turno_dia')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente_dia');
    }
};
