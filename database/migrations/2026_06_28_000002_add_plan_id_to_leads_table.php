<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Permite vincular o plano escolhido ao lead, garantindo a
            // atribuição correta do plano quando o webhook do Asaas confirmar
            // o pagamento (antes o webhook caía sempre no plano padrão).
            $table->foreignId('plan_id')->nullable()->after('template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('plan_id');
        });
    }
};
