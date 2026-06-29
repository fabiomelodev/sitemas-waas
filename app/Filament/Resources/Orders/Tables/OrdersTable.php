<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Helpers\FormatCurrency;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asaas_payment_id')
                    ->label('Asaas Pagamento ID')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Preço')
                    ->formatStateUsing(fn (string $state): string => FormatCurrency::getFormatCurrency($state))
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->label('Meio de Pagamento')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'CREDIT_CARD' => 'Crédito'
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => 'Concluído',
                        default => $state,
                    })
                    ->colors([
                        'active' => 'success',
                        'inactive' => 'danger',
                    ]),
                TextColumn::make('paid_at')
                    ->label('Pago Em')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
