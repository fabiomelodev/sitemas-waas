<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\{Hash, Password};
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    // Exibe a tela para o cliente digitar a nova senha
    public function create(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Processa a nova senha
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // 1. Gera um token aleatório e salva no usuário (ou numa tabela temporária)
                $loginToken = Str::random(40);
                $user->update(['login_token' => $loginToken]); // Adicione essa coluna na migration de users
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = User::query()->where('email', $request->email)->first();
            // 2. Redireciona passando o token na URL
            return redirect()->away("https://app.sitemas.com.br/autologin/{$user->login_token}");
        }
    }
}
