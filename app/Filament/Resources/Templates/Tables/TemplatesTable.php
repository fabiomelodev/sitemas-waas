<?php

namespace App\Filament\Resources\Templates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable(),
                TextColumn::make('plans.name')
                    ->label('Planos')
                    ->badge(),
                TextColumn::make('url')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Ativo',
                        'inactive' => 'Inativo',
                        default => $state,
                    })
                    ->colors([
                        'active' => 'success',
                        'inactive' => 'danger',
                    ]),
                TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Ativo',
                        'inactive' => 'Inativo',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
