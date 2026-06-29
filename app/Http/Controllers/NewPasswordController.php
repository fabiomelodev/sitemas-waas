<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    // Exibe a tela para o cliente digitar a nova senha
    public function create(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
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
                    'password_set_at' => now(),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $message = match ($status) {
                Password::INVALID_TOKEN => 'Este link de criação de conta é inválido ou expirou. Solicite um novo e-mail.',
                Password::INVALID_USER => 'Não encontramos uma conta com este e-mail.',
                Password::RESET_THROTTLED => 'Você tentou muitas vezes. Aguarde alguns instantes e tente novamente.',
                default => 'Não foi possível criar sua conta. Tente novamente.',
            };

            return back()->withErrors(['password' => $message]);
        }

        // Autentica o cliente e o leva direto ao painel (/painel), sem
        // depender de um app externo de autologin.
        $user = User::query()->where('email', $request->email)->first();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('filament.client.pages.dashboard'));
    }
}
