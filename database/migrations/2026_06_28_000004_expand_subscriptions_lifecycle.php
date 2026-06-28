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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Antes a coluna era um enum ['active','inactive']. O ciclo de vida
            // real de uma assinatura precisa de mais estados:
            // pending, active, past_due, canceled.
            $table->string('status')->default('pending')->change();

            // asaas_subscription_id pode ser nulo em estados transitórios/legados.
            $table->string('asaas_subscription_id')->nullable()->change();

            $table->timestamp('canceled_at')->nullable()->after('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('canceled_at');
            $table->string('asaas_subscription_id')->nullable(false)->change();
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};
