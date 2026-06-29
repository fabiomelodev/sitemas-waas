<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Telefone / Celular')
                    ->searchable(),
                TextColumn::make('asaas_customer_id')
                    ->label('ID do Cliente no Asaas')
                    ->searchable(),
            ])
            ->recordActions([
                Action::make('contact')
                    ->label('Chamar no Whats')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (User $record): string => 'https://wa.me/55'.preg_replace('/[^0-9]/', '', $record->phone).'?text='.urlencode("Olá {$record->name}, vi que você assinou o plano da Sitemas! Sou o seu consultor e vou te ajudar com a configuração."))
                    ->openUrlInNewTab(),
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
