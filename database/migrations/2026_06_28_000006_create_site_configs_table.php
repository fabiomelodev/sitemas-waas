<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * A tabela site_configs existia apenas no banco de desenvolvimento, sem
     * migration versionada — o que quebrava qualquer ambiente novo (CI, deploy,
     * testes). Esta migration formaliza o schema e é idempotente: pula a criação
     * onde a tabela já existe.
     */
    public function up(): void
    {
        if (Schema::hasTable('site_configs')) {
            return;
        }

        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('domain')->nullable();
            $table->string('brand')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_finished')->default(false);
            $table->foreignId('subscription_id')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_configs');
    }
};
