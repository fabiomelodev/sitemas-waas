<?php

namespace App\Filament\Client\Resources\Subscriptions;

use App\Filament\Client\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Helpers\FormatCurrency;
use App\Models\Subscription;
use App\Services\AsaasService;
use App\Services\PaymentService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $label = 'Minha Assinatura';

    protected static ?string $pluralLabel = 'Minha Assinatura';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('plan.name')
                    ->label('Plano')
                    ->placeholder('—'),
                TextColumn::make('plan.price')
                    ->label('Valor')
                    ->formatStateUsing(fn ($state): string => $state ? FormatCurrency::getFormatCurrency($state).'/mês' : '—'),
                TextColumn::make('template.name')
                    ->label('Modelo')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'active' => 'Ativa',
                        'pending' => 'Pendente',
                        'past_due' => 'Em atraso',
                        'canceled' => 'Cancelada',
                        default => $state ?? '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'past_due', 'canceled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('expires_at')
                    ->label('Próxima renovação')
                    ->date('d/m/Y')
                    ->placeholder('—'),
            ])
            ->recordActions([
                Action::make('pay')
                    ->label('Pagar / 2ª via')
                    ->icon('heroicon-o-banknotes')
                    ->color('warning')
                    ->visible(fn (Subscription $record): bool => (bool) $record->asaas_subscription_id
                        && in_array($record->status, ['pending', 'past_due']))
                    ->action(function (Subscription $record) {
                        $url = app(AsaasService::class)->getSubscriptionCheckoutUrl($record->asaas_subscription_id);

                        if (! $url) {
                            Notification::make()
                                ->danger()
                                ->title('Não foi possível obter o link de pagamento agora. Tente novamente em instantes.')
                                ->send();

                            return null;
                        }

                        return redirect()->away($url);
                    }),

                Action::make('cancel')
                    ->label('Cancelar assinatura')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Subscription $record): bool => $record->status === 'active')
                    ->requiresConfirmation()
                    ->modalHeading('Cancelar assinatura')
                    ->modalDescription('Tem certeza? Seu site permanecerá no ar até o fim do período já pago.')
                    ->modalSubmitActionLabel('Sim, cancelar')
                    ->action(function (Subscription $record) {
                        if ($record->asaas_subscription_id) {
                            $cancelled = app(AsaasService::class)->cancelSubscription($record->asaas_subscription_id);

                            if (! $cancelled) {
                                Notification::make()
                                    ->danger()
                                    ->title('Não foi possível cancelar agora. Tente novamente em instantes.')
                                    ->send();

                                return;
                            }

                            app(PaymentService::class)->cancelSubscription($record->asaas_subscription_id);
                        } else {
                            $record->update(['status' => 'canceled', 'canceled_at' => now()]);
                        }

                        Notification::make()
                            ->success()
                            ->title('Assinatura cancelada')
                            ->body('Você receberá um e-mail de confirmação.')
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
        ];
    }
}
