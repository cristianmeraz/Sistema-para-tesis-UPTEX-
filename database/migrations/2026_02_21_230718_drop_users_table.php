<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Eliminar tablas huérfanas de Laravel por defecto
     */
    public function up(): void
    {
        // Eliminar tablas que fueron creadas con 'users' pero NUNCA se usan en el sistema
        // El sistema usa la tabla 'usuarios' en su lugar
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }

    /**
     * Reverse the migrations - NO NECESARIO RECREAR (código muerto)
     */
    public function down(): void
    {
        // No recrear estas tablas, ya que son código muerto del proyecto
        // El sistema nuevamente usará 'usuarios' si es necesario
    }
};
