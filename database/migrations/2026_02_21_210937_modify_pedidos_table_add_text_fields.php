<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Agregar campos de texto para solicitante y receptor en destino
            $table->string('solicitado_por_texto')->nullable()->after('area_destino_id');
            $table->string('recibido_destino_por_texto')->nullable()->after('recibido_destino_por');
            
            // Agregar fecha de recibido en destino
            $table->date('fecha_recibido_destino')->nullable()->after('recibido_destino_por_texto');
            
            // Eliminar claves foráneas que serán reemplazadas por campos de texto
            $table->dropForeign(['solicitado_por']);
            $table->dropForeign(['recibido_destino_por']);
            
            // Hacer los campos originales nullable
            $table->dropColumn('solicitado_por');
            $table->dropColumn('recibido_destino_por');
        });
        
        Schema::table('pedidos', function (Blueprint $table) {
            // Agregar los campos como referencias opcionales a usuarios
            $table->foreignId('solicitado_por_usuario')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('recibido_destino_por_usuario')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar los nuevos campos
            $table->dropForeign(['solicitado_por_usuario']);
            $table->dropForeign(['recibido_destino_por_usuario']);
            $table->dropColumn(['solicitado_por_texto', 'recibido_destino_por_texto', 'fecha_recibido_destino', 'solicitado_por_usuario', 'recibido_destino_por_usuario']);
            
            // Restaurar los campos originales
            $table->foreignId('solicitado_por')->constrained('users')->onDelete('restrict');
            $table->foreignId('recibido_destino_por')->nullable()->constrained('users')->onDelete('set null');
        });
    }
};
