<?php

namespace App\Filament\Client\Resources\Subscriptions;

use App\Filament\Client\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Helpers\FormatCurrency;
use App\Models\Subscription;
use BackedEnum;
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
        ];
    }
}
