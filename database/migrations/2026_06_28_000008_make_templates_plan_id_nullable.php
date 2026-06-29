<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * O vínculo de plano passou para o pivô plan_template, então a coluna
     * legada plan_id deixa de ser obrigatória (mantida apenas por compatibilidade).
     */
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable(false)->change();
        });
    }
};
