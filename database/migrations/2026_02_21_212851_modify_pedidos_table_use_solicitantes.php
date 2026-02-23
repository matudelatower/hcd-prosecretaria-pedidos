<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Reemplazar campos de texto por claves foráneas a solicitantes
            $table->dropColumn(['solicitado_por_texto', 'recibido_destino_por_texto']);
            
            // Agregar nuevas claves foráneas
            $table->foreignId('solicitado_por_id')->nullable()->constrained('solicitantes')->onDelete('set null');
            $table->foreignId('recibido_destino_por_id')->nullable()->constrained('solicitantes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar las nuevas claves foráneas
            $table->dropForeign(['solicitado_por_id']);
            $table->dropForeign(['recibido_destino_por_id']);
            $table->dropColumn(['solicitado_por_id', 'recibido_destino_por_id']);
            
            // Restaurar los campos de texto
            $table->string('solicitado_por_texto')->nullable();
            $table->string('recibido_destino_por_texto')->nullable();
        });
    }
};
