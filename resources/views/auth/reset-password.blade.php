<form method="POST" action="{{ route('password.update') }}" class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <h2 class="text-xl font-bold mb-4">Defina sua senha de acesso</h2>

    <div class="mb-4">
        <label class="block text-sm">Nova Senha</label>
        <input type="password" name="password" required class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block text-sm">Confirme a Senha</label>
        <input type="password" name="password_confirmation" required class="w-full border rounded p-2">
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold">
        Acessar meu Painel
    </button>
</form>