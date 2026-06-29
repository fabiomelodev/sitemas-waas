<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Campos de briefing (conteúdo enviado pelo cliente) e o estágio do site
     * no pipeline de produção.
     */
    public function up(): void
    {
        Schema::table('site_configs', function (Blueprint $table) {
            // Pipeline: received -> in_progress -> review -> live
            $table->string('stage')->default('received')->after('is_finished');

            // Briefing / conteúdo do site
            $table->text('about')->nullable()->after('stage');
            $table->text('services')->nullable()->after('about');
            $table->string('primary_color')->nullable()->after('services');
            $table->string('business_hours')->nullable()->after('primary_color');
            $table->string('address')->nullable()->after('business_hours');
            $table->json('photos')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_configs', function (Blueprint $table) {
            $table->dropColumn(['stage', 'about', 'services', 'primary_color', 'business_hours', 'address', 'photos']);
        });
    }
};
