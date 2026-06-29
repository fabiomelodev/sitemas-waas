<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Um modelo (template) agora pode estar vinculado a mais de um plano.
     */
    public function up(): void
    {
        Schema::create('plan_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->unique(['plan_id', 'template_id']);
        });

        // Migra o vínculo único existente (templates.plan_id) para o pivô.
        DB::table('templates')->whereNotNull('plan_id')->orderBy('id')->each(function ($template) {
            DB::table('plan_template')->insertOrIgnore([
                'plan_id' => $template->plan_id,
                'template_id' => $template->id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_template');
    }
};
