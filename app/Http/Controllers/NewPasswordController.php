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

        // O broker do Laravel valida se o token é real e pertence ao e-mail
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        dd(true);

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Senha definida com sucesso!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
