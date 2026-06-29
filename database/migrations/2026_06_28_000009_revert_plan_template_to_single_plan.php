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
     * Reverte o vínculo para 1 modelo ↔ 1 plano: remove o pivô plan_template
     * e volta templates.plan_id a ser obrigatório.
     */
    public function up(): void
    {
        Schema::dropIfExists('plan_template');

        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->change();
        });

        Schema::create('plan_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->unique(['plan_id', 'template_id']);
        });

        DB::table('templates')->whereNotNull('plan_id')->orderBy('id')->each(function ($template) {
            DB::table('plan_template')->insertOrIgnore([
                'plan_id' => $template->plan_id,
                'template_id' => $template->id,
            ]);
        });
    }
};
