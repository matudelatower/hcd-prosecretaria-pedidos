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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_expediente')->nullable();
            $table->text('descripcion');
            $table->date('fecha_solicitud');
            $table->foreignId('solicitado_por')->constrained('users')->onDelete('restrict');
            $table->foreignId('area_destino_id')->constrained('areas')->onDelete('restrict');
            $table->date('fecha_recepcion')->nullable();
            $table->foreignId('recibido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->date('fecha_envio')->nullable();
            $table->foreignId('enviado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('recibido_destino_por')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado', ['solicitado', 'recibido', 'enviado', 'entregado'])->default('solicitado');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
