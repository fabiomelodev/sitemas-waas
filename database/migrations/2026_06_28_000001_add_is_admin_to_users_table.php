<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });

        // Mantém o acesso dos administradores já existentes ao painel.
        // Defina ADMIN_EMAILS no .env (separados por vírgula) antes de migrar.
        $adminEmails = collect(explode(',', (string) env('ADMIN_EMAILS', 'fabiomelodev@gmail.com')))
            ->map(fn (string $email): string => trim($email))
            ->filter()
            ->all();

        if (! empty($adminEmails)) {
            DB::table('users')->whereIn('email', $adminEmails)->update(['is_admin' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
