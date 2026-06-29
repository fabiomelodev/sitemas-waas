<?php

namespace App\Filament\Resources\SiteConfigs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SiteConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Nome da Empresa')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->sortable(),
                TextColumn::make('domain')
                    ->label('Domínio')
                    ->searchable(),
                TextColumn::make('subscription.plan.name')
                    ->label('Assinatura / Plano')
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        1 => 'Ativo',
                        0 => 'Inativo',
                    ]),
            ])
            ->recordActions([
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
