<?php

namespace App\Filament\Client\Pages;

use App\Services\AsaasService;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $title = 'Meu Perfil';

    protected static ?string $navigationLabel = 'Meu Perfil';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.client.pages.profile';

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'cpf_cnpj' => $user->cpf_cnpj,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Dados pessoais')
                    ->description('Mantenha seus dados atualizados. Eles também são usados na emissão das cobranças.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome completo')
                            ->required(),
                        TextInput::make('email')
                            ->label('E-mail de acesso')
                            ->disabled()
                            ->helperText('Para alterar o e-mail, fale com o suporte.'),
                        TextInput::make('phone')
                            ->label('WhatsApp')
                            ->required(),
                        TextInput::make('cpf_cnpj')
                            ->label('CPF / CNPJ')
                            ->required(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'cpf_cnpj' => $data['cpf_cnpj'],
        ]);

        // Mantém o cliente sincronizado no Asaas (nome/telefone/CPF da cobrança).
        if ($user->asaas_customer_id) {
            app(AsaasService::class)->updateCustomer($user->asaas_customer_id, [
                'name' => $data['name'],
                'email' => $user->email,
                'phone' => $data['phone'],
                'cpf_cnpj' => $data['cpf_cnpj'],
            ]);
        }

        Notification::make()
            ->success()
            ->title('Perfil atualizado')
            ->send();
    }
}
